<?php 

namespace phpDocumentor\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Composer\Script\Event;
use Composer\Package\Locker;
use Composer\Composer;
use Composer\Config;
use Composer\Package\RootPackageInterface;
use Composer\Package\AliasPackage;
use Composer\Package\Dumper\ArrayDumper;

class DemoPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        // Nothing to do here, as all features are provided through event listeners
    }


    public static function getSubscribedEvents()
    {
        return [
            'post-autoload-dump' => 'dumpAll',
            ScriptEvents::POST_UPDATE_CMD => 'dumpAll'
        ];
    }

    public static function dumpAll(Event $composerEvent)
    {
        $io = $composerEvent->getIO();
        $io->write('<info>thadafinser/package-info:</info>  Generating class...');
        $io->write('<info>thadafinser/package-info:</info> ...generating class');
    }
}