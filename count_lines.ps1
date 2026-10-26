$files = @(
    '07.02-request-lifecycle.md',
    '07.03-domain-driven-design.md',
    '07.04-module-architecture.md',
    '07.05-folder-structure.md',
    '07.06-service-layer.md',
    '07.07-repository-layer.md',
    '07.08-action-layer.md',
    '07.09-dto-layer.md'
)
foreach ($f in $files) {
    $p = 'C:\Users\SHAMIM.IT\Desktop\gsmui\gsmui-prd\07-backend-architecture\' + $f
    $c = (Get-Content $p).Count
    Write-Output "$f : $c lines"
}
