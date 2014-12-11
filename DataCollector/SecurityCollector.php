<?php

namespace BW\SecurityCheckerBundle\DataCollector;

use BW\SecurityCheckerBundle\Entity\VulnerabilityReport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Class SecurityCollector
 * @package BW\SecurityCheckerBundle\DataCollector
 */
class SecurityCollector extends DataCollector
{
    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var VulnerabilityReport
     */
    private $vulnerabilityReport;

    /**
     * @param string $cacheDir
     */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function unserialize($data)
    {
        parent::unserialize($data);
        if (isset($this->data['cachedReportPath'])) {
            $this->restoreFromCache($this->data['cachedReportPath']);
        }
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $cachedReportPath = $this->cacheDir . '/' . VulnerabilityReport::FILENAME;
        $this->data = ['cachedReportPath' => $cachedReportPath];
        $this->restoreFromCache($cachedReportPath);
    }

    public function getVulnerabilityReport()
    {
        return $this->vulnerabilityReport;
    }

    public function countPackages()
    {
        $count = 0;

        if ($this->vulnerabilityReport) {
            $count = count($this->vulnerabilityReport->getPackages());
        }

        return $count;
    }

    public function countAdvisories()
    {
        $count = 0;

        if ($this->vulnerabilityReport) {
            foreach ($this->vulnerabilityReport->getPackages() as $package) {
                $count += count($package['advisories']);
            }
        }

        return $count;
    }

    public function getName()
    {
        return 'bw_security_checker';
    }

    private function restoreFromCache($cachedReportPath)
    {
        if (! file_exists($cachedReportPath)) {
            return;
        }
        $vulnerabilityReport = unserialize(file_get_contents($cachedReportPath));
        if (! $vulnerabilityReport instanceof VulnerabilityReport) {
            return;
        }
        $this->vulnerabilityReport = $vulnerabilityReport;
    }
}
