<?php

namespace App\Livewire;

use DB;
use Livewire\Component;

class Installer extends Component
{
    public string $phpVersion = '1.0';
    public array $extensionChecks = [
        'ctype' => false,
        'curl' => false,
        'dom' => false,
        'fileinfo' => false,
        'filter' => false,
        'hash' => false,
        'mbstring' => false,
        'openssl' => false,
        'pcre' => false,
        'pdo' => false,
        'session' => false,
        'tokenizer' => false,
        'xml' => false
    ];
    public bool $isPHPVersionOK = false;

    public bool $isDBConfigured = false;
    public string $dbError = '';

    public bool $noStartInstallation = false;

    private function canInstall()
    {
        $canNotInstall = false;
        if(!$this->isPHPVersionOK)
            $canNotInstall = true;

        if(!$this->isDBConfigured || $this->noStartInstallation)
            $canNotInstall = true;

        foreach($this->extensionChecks as $value)
        {
            if(!$value || $this->noStartInstallation) {
                $canNotInstall = true;
                break;
            }
        }
        return !$canNotInstall;
    }

    public function install()
    {
        if($this->canInstall())
        {
            \Artisan::call('migrate:fresh', ['--force' => true]);
            redirect('register');
        }

    }

    public function mount()
    {
        preg_match("#^\d+(\.\d+)*#", phpversion(), $match);
        $this->phpVersion = $match[0];
        if(version_compare('8.1.0', $this->phpVersion) <= 0)
            $this->isPHPVersionOK = true;

        foreach ($this->extensionChecks as $ext => $value)
        {
            if(extension_loaded($ext))
            {
                $this->extensionChecks[$ext] = true;
            }
        }

        try {
            $con = DB::connection()->getPdo();
            $this->isDBConfigured = true;
        } catch (\Exception $e) {
            $this->dbError = __('No Connection to Database ').DB::connection()->getDatabaseName();
        }

        $this->noStartInstallation = !$this->canInstall();
    }

    public function render()
    {
        return view('livewire.installer')->layout('layouts.guest');
    }
}
