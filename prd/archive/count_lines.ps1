$files = Get-ChildItem 'C:\Users\SHAMIM.IT\Desktop\gsmui\gsmui-prd\09-authentication\*.md'
foreach ($f in $files) {
    $c = [System.IO.File]::ReadAllLines($f.FullName).Length
    Write-Host "$($f.Name): $c lines"
}
