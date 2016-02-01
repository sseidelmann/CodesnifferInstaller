<?php
/**
 * Class PhpCodesnifferStandardInstallerPlugin.
 * @package Seidelmann\CodesnifferInstaller
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */

namespace Seidelmann\CodesnifferInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Seidelmann\CodesnifferInstaller\Installers\PhpCodesnifferStandardInstaller;

/**
 * Class PhpCodesnifferStandardInstallerPlugin.
 * @package Seidelmann\CodesnifferInstaller
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */
class PhpCodesnifferStandardInstallerPlugin implements PluginInterface
{
	/**
	 * Activates the installer.
	 * @param Composer    $composer
	 * @param IOInterface $io
	 * @return void
	 */
	public function activate(Composer $composer, IOInterface $io)
	{
		$installer = new PhpCodesnifferStandardInstaller($io, $composer);

		$composer->getInstallationManager()->addInstaller($installer);
	}
}
