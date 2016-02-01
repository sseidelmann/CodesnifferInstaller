<?php
/**
 * Class PhpCodesnifferStandardInstallerTest
 * @package Test\Seidelmann\CodesnifferInstaller\Installers
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */

namespace Test\Seidelmann\CodesnifferInstaller\Installers;

use Composer\Package\Package;
use Composer\TestCase;
use Seidelmann\CodesnifferInstaller\Installers\PhpCodesnifferStandardInstaller;

/**
 * Class PhpCodesnifferStandardInstallerTest
 * @package Test\Seidelmann\CodesnifferInstaller\Installers
 * @author Sebastian Seidelmann <sebastian.seidelmann@googlemail.com>
 */
class PhpCodesnifferStandardInstallerTest extends TestCase
{
    /**
     * Saves the composer mock instance.
     * @var \Composer\Composer
     */
    protected $composer;

    /**
     * Saves the installation manager instance.
     * @var \Composer\Installer\InstallationManager
     */
    protected $im;

    /**
     * Saves the io instance.
     * @var \Composer\IO\IOInterface
     */
    protected $io;

    /**
     * Saves the data manager.
     * @var PackageDataManagerInterfac|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataManager;

    /**
     * Saves the dependencies directory.
     * @var string
     */
    protected $vendorDir;

    /**
     * Setup.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->vendorDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'composer-test-vendor';
        $this->ensureDirectoryExistsAndClear($this->vendorDir);

        $this->composer = new \Composer\Composer();
        $config = new \Composer\Config();
        $this->composer->setConfig($config);

        /** @var \Composer\Package\RootPackageInterface|\PHPUnit_Framework_MockObject_MockObject $package */
        $package = $this->getMock('Composer\Package\RootPackageInterface');
        $package
            ->expects($this->any())
            ->method('getExtra')
            ->willReturn(array(
                PhpCodesnifferStandardInstaller::PACKAGE_TYPE => array(
                    'vendor-dir'  => $this->vendorDir
                )
            )
        );

        $config->merge(array(
            'config' => array(
                'vendor-dir' => $this->vendorDir
            ),
        ));

        $this->composer->setPackage($package);
        $this->im = $this->getMock('Composer\Installer\InstallationManager');
        $this->composer->setInstallationManager($this->im);
        $this->io = $this->getMock('Composer\IO\IOInterface');
    }

    /**
     * Tests the TYPO3 coding guidelines installer path.
     * @test
     * @return void
     */
    public function getInstallPathForTypo3CodingGuidelines()
    {
        $installer = $this->createInstaller();
        $package = $this->createPackageMock('vendor/typo3-coding-guidelines');

        $this->assertEquals(
            $this->vendorDir . '/squizlabs/php_codesniffer/CodeSniffer/Standards/TYPO3CodingGuidelines',
            $installer->getInstallPath($package)
        );
    }

    /**
     * Tests the default coding guidelines installer path.
     * @test
     * @return void
     */
    public function getInstallPathForDefaultCodingGuidelines()
    {
        $installer = $this->createInstaller();
        $package = $this->createPackageMock('vendor/coding-guidelines');

        $this->assertEquals(
            $this->vendorDir . '/squizlabs/php_codesniffer/CodeSniffer/Standards/CodingGuidelines',
            $installer->getInstallPath($package)
        );
    }

    /**
     * Creates the installer.
     * @return PhpCodesnifferStandardInstaller
     */
    protected function createInstaller()
    {
        return new PhpCodesnifferStandardInstaller(
            $this->io,
            $this->composer,
            PhpCodesnifferStandardInstaller::PACKAGE_TYPE
        );
    }

    /**
     * Creates a basic package.
     * @param string $prettyName
     * @return Package|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createPackageMock($prettyName = 'sseidelmann/foo-bar')
    {
        /** @var Package|\PHPUnit_Framework_MockObject_MockObject $package */
        $package = $this->getMockBuilder('Composer\Package\Package')
            ->setConstructorArgs(array(md5(mt_rand()), 'dev-develop', 'dev-develop'))
            ->getMock()
        ;
        $package
            ->expects($this->any())
            ->method('getType')
            ->willReturn(PhpCodesnifferStandardInstaller::PACKAGE_TYPE)
        ;
        $package
            ->expects($this->any())
            ->method('getPrettyName')
            ->willReturn($prettyName)
        ;
        $package
            ->expects($this->any())
            ->method('getPrettyVersion')
            ->willReturn('dev-develop')
        ;
        $package
            ->expects($this->any())
            ->method('getVersion')
            ->willReturn('dev-develop')
        ;
        $package
            ->expects($this->any())
            ->method('getInstallationSource')
            ->willReturn('source')
        ;
        return $package;
    }

}