<?php

namespace BW\SecurityCheckerBundle\Controller;

use BW\SecurityCheckerBundle\Entity\VulnerabilityReport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 * @package BW\SecurityCheckerBundle\Controller
 * @Route("/bw")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/security/check", name="bw_security_check")
     */
    public function checkAction(Request $request)
    {
        $kernel = $this->get('kernel');
        $fs = $this->get('filesystem');
        $checker = $this->get('sensio_distribution.security_checker');

        $lockFilePath = $kernel->getRootDir() . '/../' . VulnerabilityReport::LOCK_FILENAME;
        if (! $fs->exists($lockFilePath)) {
            throw new \RuntimeException('Composer lock file not exist. Maybe run "composer update" first?');
        }
        $result = $checker->check($lockFilePath);
        $cachedFilePath = $kernel->getCacheDir() . '/' . VulnerabilityReport::FILENAME;
        if (is_array($result)) {
            $fs->dumpFile($cachedFilePath, serialize(new VulnerabilityReport($result)));
        } else {
            if ($fs->exists($cachedFilePath)) {
                $fs->remove($cachedFilePath);
            }
        }

        return new RedirectResponse($request->server->get('HTTP_REFERER'));
    }
}
