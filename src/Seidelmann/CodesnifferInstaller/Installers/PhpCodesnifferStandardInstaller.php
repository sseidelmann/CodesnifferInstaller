<?php
/**
 * Class PhpCodesnifferStandardInstaller
 * @package Seidelmann\CodesnifferInstaller\Installers
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */

namespace Seidelmann\CodesnifferInstaller\Installers;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * Class PhpCodesnifferStandardInstaller
 * @package Seidelmann\CodesnifferInstaller\Installers
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */
class PhpCodesnifferStandardInstaller extends LibraryInstaller
{
	/**
	 * Defines the package type.
	 * @var string
	 */
	const PACKAGE_TYPE = 'phpcodesniffer-standard';

	/**
	 * Returns the install path.
	 * @param PackageInterface $package
	 * @return string
	 */
	public function getInstallPath(PackageInterface $package)
	{
		return $this->getPackageBasePath($package);
	}

	/**
	 * Returns the package base path.
	 * @param PackageInterface $package
	 * @return string
	 */
	protected function getPackageBasePath(PackageInterface $package)
	{
		$this->initializeVendorDir();

		$targetPath = $this->vendorDir ? $this->vendorDir . DIRECTORY_SEPARATOR : '';

		$codeSnifferStandardsPathParts = array('squizlabs', 'php_codesniffer', 'CodeSniffer', 'Standards');
		$targetPath .= implode(DIRECTORY_SEPARATOR, $codeSnifferStandardsPathParts) . DIRECTORY_SEPARATOR;

		$packageKeyParts = explode('/', $package->getPrettyName(), 2);

		$codeStandardName = str_replace('Typo3', 'TYPO3', ucfirst($packageKeyParts[1]));
		$codeStandardName = preg_replace_callback('/-([a-z]{1})/', function($matches) { return strtoupper($matches[1]); }, $codeStandardName);

		return $targetPath . $codeStandardName;
	}

	/**
	 * Checks if the package type is a valid package for installation.
	 * @param string $packageType
	 * @return boolean
	 */
	public function supports($packageType)
	{
		return $packageType === self::PACKAGE_TYPE;
	}

}