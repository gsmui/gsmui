$files = @('06.55-licenses.md','06.56-downloads.md','06.57-reviews.md','06.58-coupons.md','06.70-documentation.md','06.80-playground.md','06.81-snippets.md','06.91-cms.md')
foreach ($f in $files) {
    $path = 'C:\Users\SHAMIM.IT\Desktop\gsmui\gsmui-prd\06-database-design\' + $f
    $count = [System.IO.File]::ReadAllLines($path).Length
    Write-Host "$f : $count lines"
}
