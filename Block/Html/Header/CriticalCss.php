<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace DNAFactory\Critical\Block\Html\Header;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;
use Magento\Framework\View\Asset\Repository;

/**
 * This ViewModel will add inline critical css in case dev/css/use_css_critical_path is enabled.
 */
class CriticalCss extends \Magento\Theme\Block\Html\Header\CriticalCss
{
    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * @var $filePath
     */
    private $filePath;

    /**
     * @var \Magento\Framework\Filesystem $filesystem
     */
    private $filesystem;
    /**
     * @var \Magento\Framework\App\State $appState
     */
    private $appState;

    /**
     * @param Repository $assetRepo
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\App\State $appState
     * @param string $filePath
     */
    public function __construct(
        Repository $assetRepo,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\App\State $appState,
        string $filePath = ''
    ) {
        parent::__construct($assetRepo, $filePath);
        $this->assetRepo = $assetRepo;
        $this->filePath = $filePath;
        $this->filesystem = $filesystem;
        $this->appState = $appState;
    }

    /**
     * Returns critical css data as string.
     *
     * @return bool|string
     */
    public function getCriticalCssData()
    {
        try {
            $asset = $this->assetRepo->createAsset($this->filePath, ['_secure' => 'false']);
            $dir = $this->filesystem->getDirectoryRead(DirectoryList::STATIC_VIEW);
            if ($dir->isExist($asset->getPath())) {
                $content = $dir->readFile($asset->getPath());
                $resUrl = $this->assetRepo->getUrl('');
                if (substr($resUrl, -1) != "/") {
                    $resUrl .= "/";
                }

                $content = preg_replace('/(\'|\")(\.\.\/)/', "$1" . $resUrl, $content);
            }else if($this->appState->getMode() != State::MODE_PRODUCTION){
                $content = $asset->getContent();
            }
        } catch (\Exception $e) {
            $content = '';
        }

        return (isset($content))? $content : '';
    }
}

