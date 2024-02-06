$PHP_INSTALL_DIR = 'C:\php'
$PHP_IN_PATH = 0
$PHP_8_3_URL = "https://windows.php.net/downloads/releases/php-8.3.2-Win32-vs16-x64.zip"
$DL_DEST = "C:\php\php.zip"
$PHP_CONFIG_PATH = "C:\php\php.ini"
$PHP_PROD_CONFIG_PATH = "C:\php\php.ini-production"
$PHP_PATH="php.exe"
$SCRIPT_PATH = split-path -parent $MyInvocation.MyCommand.Definition
$DB_PATH = "$SCRIPT_PATH\database\database.sqlite"




#Check if php.exe is already in $PATH
if ((Get-Command $PHP_PATH -ErrorAction SilentlyContinue) -eq $null)
{
    Write-Output "PHP is not in PATH"
    #Check if a path for php already exists
    if (Test-Path -Path $PHP_INSTALL_DIR) {
        Write-Output "PHP Path exists, skipping dowload"
    } else {
        New-Item -ItemType Directory -Path C:\php
        Invoke-WebRequest -Uri $PHP_8_3_URL -OutFile $DL_DEST
        Expand-Archive -LiteralPath $DL_DEST -DestinationPath $PHP_INSTALL_DIR
        $PHP_PATH = C:\php\php.exe
    }

    $PHP_PATH = 'C:\php\php.exe'

    if(Test-Path $PHP_CONFIG_PATH -PathType Leaf)
    {
        Write-Output "PHP ini exists, skipping extension activation"
    } else {
        $content = Get-Content $PHP_PROD_CONFIG_PATH
        $content | ForEach-Object {$_ -replace ";extension=curl", "extension=curl" -replace ";extension=fileinfo", "extension=fileinfo" -replace ";extension=mbstring", "extension=mbstring" -replace ";extension=openssl", "extension=openssl" -replace ";extension=pdo_mysql", "extension=pdo_mysql" -replace ";extension=pdo_sqlite", "extension=pdo_sqlite"} | Set-Content $PHP_CONFIG_PATH
    }
}

Get-Content "$SCRIPT_PATH\.env" | Where { $_ } | foreach {
  $name, $value = $_.split('=')

  if ([string]::IsNullOrWhiteSpace($name) -or $name.Contains('#')) {
    continue
  }

  if($name.Equals("APP_KEY") -and [string]::IsNullOrWhiteSpace($value))
  {
      Write-Output "Generating App Key"
      & "$PHP_PATH" @("$SCRIPT_PATH\artisan", 'key:generate', '--force')
  }
}

& "$PHP_PATH" @("$SCRIPT_PATH\artisan", 'config:clear')
& "$PHP_PATH" @("$SCRIPT_PATH\artisan", 'cache:clear')
$content = Get-Content "$SCRIPT_PATH\.env"
$content | ForEach-Object {$_ -replace "DB_CONNECTION=mysql", "DB_CONNECTION=sqlite" -replace "DB_DATABASE=palworld_admin_panel", ""} | Set-Content "$SCRIPT_PATH\.env"

if(Test-Path $DB_PATH -PathType Leaf)
{
    Write-Output "DB File Exists."
}
else
{
    Write-Output "Creating new file"
    New-Item -type file "$DB_PATH"
}
Write-Output ".env Adjusted"

#Onetime
Start-Process -NoNewWindow -FilePath "$PHP_PATH" -ArgumentList "$SCRIPT_PATH\artisan", "serve", "--host=127.0.0.1", "--port=80"
Start-Process -NoNewWindow -FilePath "$PHP_PATH" -ArgumentList "$SCRIPT_PATH\artisan", "short-schedule:run"

#New-Service -Name "Palworld Admin Tool WebService" -BinaryPathName "$PHP_PATH $SCRIPT_PATH\artisan serve --host=127.0.0.1 --port=80"
#New-Service -Name "Palworld Admin Tool Scheduler" -BinaryPathName "$PHP_PATH $SCRIPT_PATH\artisan short-schedule:run"

#Service Part
#Start-Process -FilePath powershell.exe -Verb RunAs -Wait -ArgumentList '-Command', "function myService() {New-Service -Name `"Palworld Admin Tool WebService`" -BinaryPathName `"$PHP_PATH $SCRIPT_PATH\artisan serve --host=127.0.0.1 --port=80`"};myService"
#Start-Process -FilePath powershell.exe -Verb RunAs -Wait -ArgumentList '-Command', "function myService() {New-Service -Name `"Palworld Admin Tool Scheduler`" -BinaryPathName `"$PHP_PATH $SCRIPT_PATH\artisan short-schedule:run`"};myService"


#Start-Service -Name "Palworld Admin Tool WebService"
#Start-Service -Name "Palworld Admin Tool Scheduler"
