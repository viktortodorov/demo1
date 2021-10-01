<?php 

namespace Vtodorov\Demo1;

use Composer\Composer;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Script\Event;
use Composer\Package\Locker;
use Composer\Config;
use Composer\Package\RootPackageInterface;
use Composer\Package\AliasPackage;
use Composer\Package\Dumper\ArrayDumper;

class DemoPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        self::dumpAll($composer);
    }

    public static function getSubscribedEvents()
    {
        return [
            "post-autoload-dump" => [
                ['dumpAll', 0]
            ],
            "post-update" => [
                ['dumpAll', 0]
            ],
        ];
    }

    public static function dumpAll(Composer $composer)
    {
        echo ("<info>vtodorov/demo1:</info>  Generating class...\n");
        $packages = $composer->getRepositoryManager()->getLocalRepository()->getPackages();

        foreach ($packages as $package) {
            $name = $package->getName();
            $outputDir = "vendor/" . $name;

            $dirinfo = self::dirsize($outputDir);
            
            echo "** " . $name . ": size: (" . ($dirinfo['size'] / 1024) . " KB) files: " . $dirinfo['howmany'] . "\n";
        }
        
        echo ('<info>vtodorov/demo1:</info> ...generating class' . "\n");
    }

    public static function dirsize($dir) 
    {
        if(is_file($dir)) return array('size'=>filesize($dir),'howmany'=>0);
        if($dh=opendir($dir)) {
            $size=0;
            $n = 0;
            while(($file=readdir($dh))!==false) {
                if($file=='.' || $file=='..') continue;
                $n++;
                $data = self::dirsize($dir.'/'.$file);
                $size += $data['size'];
                $n += $data['howmany'];
            }
            closedir($dh);
            return array('size'=>$size,'howmany'=>$n);
        } 
        return array('size'=>0,'howmany'=>0);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // At the moment empty; needed for composer 2.x support
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // At the moment empty; needed for composer 2.x support
    }
}
