# Passkeys / WebAuthn

> Registration flow, authentication flow, browser support, fallback strategy.

## WebAuthn Configuration

```php
// config/webauthn.php
return [
    'rp_name' => config('app.name'),
    'rp_id' => parse_url(config('app.url'), PHP_URL_HOST),
    'timeout' => 60000,
    'challenge_timeout' => 300,
    'user_verification' => 'preferred',
    'attestation' => 'none',
    'algorithms' => [-7, -257], // ES256, RS256
    'transport' => ['internal', 'usb', 'ble', 'nfc'],
];
```

## Registration Flow

```php
// app/Http/Controllers/WebAuthnController.php
class WebAuthnController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        $publicKey = [
            'challenge' => Str::random(32),
            'rp' => [
                'name' => config('webauthn.rp_name'),
                'id' => config('webauthn.rp_id'),
            ],
            'user' => [
                'id' => base64_encode($user->id),
                'name' => $user->email,
                'displayName' => $user->name,
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],
                ['type' => 'public-key', 'alg' => -257],
            ],
            'authenticatorSelection' => [
                'authenticatorAttachment' => 'platform',
                'userVerification' => 'required',
            ],
            'timeout' => config('webauthn.timeout'),
            'attestation' => config('webauthn.attestation'),
        ];

        session(['webauthn_challenge' => $publicKey['challenge']]);

        return response()->json($publicKey);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'id' => ['required', 'string'],
            'rawId' => ['required', 'string'],
            'response.attestationObject' => ['required', 'string'],
            'response.clientDataJSON' => ['required', 'string'],
        ]);

        $challenge = session('webauthn_challenge');

        // Verify attestation
        $attestation = $this->parseAttestation(
            $request->input('response.attestationObject')
        );

        // Store credential
        WebAuthnCredential::create([
            'user_id' => $user->id,
            'credential_id' => $request->input('rawId'),
            'public_key' => $attestation->publicKey,
            'sign_count' => $attestation->signCount,
            'name' => $request->input('name', 'Passkey'),
            'device_type' => $attestation->deviceType,
            'backup_eligible' => $attestation->backupEligible,
            'backup_status' => $attestation->backupStatus,
            'transports' => $attestation->transports,
            'aaguid' => $attestation->aaguid,
        ]);

        session()->forget('webauthn_challenge');

        return response()->json(['message' => 'Passkey registered successfully.']);
    }
}
```

## Authentication Flow

```php
class WebAuthnLoginController extends Controller
{
    public function create(Request $request)
    {
        $publicKey = [
            'challenge' => Str::random(32),
            'timeout' => config('webauthn.timeout'),
            'rpId' => config('webauthn.rp_id'),
            'allowCredentials' => $this->getAllowedCredentials(),
            'userVerification' => 'required',
        ];

        session(['webauthn_challenge' => $publicKey['challenge']]);

        return response()->json($publicKey);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'string'],
            'rawId' => ['required', 'string'],
            'response.authenticatorData' => ['required', 'string'],
            'response.clientDataJSON' => ['required', 'string'],
            'response.signature' => ['required', 'string'],
        ]);

        $challenge = session('webauthn_challenge');

        $credential = WebAuthnCredential::where('credential_id', $request->input('rawId'))
            ->firstOrFail();

        // Verify assertion
        $this->verifyAssertion($request, $credential, $challenge);

        // Update sign count
        $credential->update([
            'sign_count' => $request->input('signCount', $credential->sign_count),
            'last_used_at' => now(),
        ]);

        // Login user
        auth()->login($credential->user);

        session()->forget('webauthn_challenge');

        return response()->json(['redirect' => '/dashboard']);
    }

    protected function getAllowedCredentials(): array
    {
        $user = auth()->user();

        return $user->webauthnCredentials->map(fn ($cred) => [
            'type' => 'public-key',
            'id' => $cred->credential_id,
            'transports' => $cred->transports,
        ])->toArray();
    }
}
```

## Frontend JavaScript

```js
// resources/js/webauthn.js
export class WebAuthn {
    static async register() {
        const response = await fetch('/webauthn/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const options = await response.json();

        const credential = await navigator.credentials.create({
            publicKey: {
                ...options,
                challenge: Uint8Array.from(atob(options.challenge), c => c.charCodeAt(0)),
                user: {
                    ...options.user,
                    id: Uint8Array.from(atob(options.user.id), c => c.charCodeAt(0)),
                },
            },
        });

        const response2 = await fetch('/webauthn/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                id: credential.id,
                rawId: credential.rawId,
                response: {
                    attestationObject: btoa(String.fromCharCode(...new Uint8Array(credential.response.attestationObject))),
                    clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON))),
                },
                type: credential.type,
            }),
        });

        return response2.json();
    }

    static async authenticate() {
        const response = await fetch('/webauthn/authenticate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const options = await response.json();

        const credential = await navigator.credentials.get({
            publicKey: {
                ...options,
                challenge: Uint8Array.from(atob(options.challenge), c => c.charCodeAt(0)),
                allowCredentials: options.allowCredentials?.map(cred => ({
                    ...cred,
                    id: Uint8Array.from(atob(cred.id), c => c.charCodeAt(0)),
                })),
            },
        });

        const response2 = await fetch('/webauthn/authenticate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                id: credential.id,
                rawId: credential.rawId,
                response: {
                    authenticatorData: btoa(String.fromCharCode(...new Uint8Array(credential.response.authenticatorData))),
                    clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON))),
                    signature: btoa(String.fromCharCode(...new Uint8Array(credential.response.signature))),
                },
                type: credential.type,
            }),
        });

        return response2.json();
    }
}
```

## Browser Support

| Browser | Platform | Support |
|---|---|---|
| Chrome 67+ | Desktop | Yes |
| Chrome 70+ | Android | Yes |
| Edge 18+ | Desktop | Yes |
| Firefox 60+ | Desktop | Yes |
| Safari 13+ | macOS | Yes |
| Safari 14+ | iOS | Yes |

## Fallback Strategy

```blade
{{-- Conditional passkey button --}}
<div x-data="{ supported: false }" x-init="supported = window.PublicKeyCredential !== undefined">
    <template x-if="supported">
        <x-gsmui::button @click="WebAuthn.authenticate()" class="w-full">
            Sign in with Passkey
        </x-gsmui::button>
    </template>

    <template x-if="!supported">
        <div class="text-center text-sm text-zinc-500">
            Passkeys not supported. Use email/password.
        </div>
    </template>
</div>
```

```php
// Fallback to password if passkey fails
class LoginController extends Controller
{
    public function login(Request $request)
    {
        if ($request->has('webauthn_response')) {
            try {
                return $this->webAuthnLogin($request);
            } catch (\Exception $e) {
                // Fall through to password login
            }
        }

        return $this->passwordLogin($request);
    }
}
```

## Passkey Management

```php
// List passkeys
$passkeys = $request->user()->webauthnCredentials;

// Rename passkey
$credential = WebAuthnCredential::find($id);
$credential->update(['name' => $request->input('name')]);

// Delete passkey
$credential->delete();

// Check if user has passkeys
$hasPasskeys = $request->user()->webauthnCredentials()->exists();
```

## Testing

```php
class WebAuthnTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_passkey(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/webauthn/register');

        $response->assertOk();
        $response->assertJsonStructure([
            'challenge',
            'rp',
            'user',
        ]);
    }

    public function test_user_can_authenticate_with_passkey(): void
    {
        $user = User::factory()->create();

        // Create credential
        WebAuthnCredential::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/webauthn/authenticate');

        $response->assertOk();
        $response->assertJsonStructure([
            'challenge',
            'rpId',
            'allowCredentials',
        ]);
    }
}
```
