<?php

namespace Rutkai\FeatureFlipperBundle\Command;

use Rutkai\FeatureFlipperBundle\Feature\FeatureInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FeatureCheckCommand
 * @package Rutkai\FeatureFlipperBundle\Command
 * @author András Rutkai
 */
class FeatureCheckCommand extends ContainerAwareCommand {

    const EXPIRED_FEATURE_CODE = 100;

    /**
     * @inheritdoc
     */
    protected function configure() {
        $this
            ->setName('rutkai:feature:check')
            ->setDescription('Checks whether any of the features are expired or going to expire.')
            ->addOption('send-warnings', 'w', InputOption::VALUE_NONE, 'If set, the command sends out warnings by e-mails')
            ->addOption('die-on-expired', 'd', InputOption::VALUE_NONE, 'If set, the command dies if there is any expired features')
            ->addOption('expiration-warning', 'x', InputOption::VALUE_REQUIRED, 'Overrides the expiration_warning config value for this execution');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $featureManager = $this->getContainer()->get('feature.manager');
        $sendWarnings = $input->getOption('send-warnings');
        $dieOnExpired = $input->getOption('die-on-expired');
        $expirationWarning = $this->getExpirationWarning($input);

        foreach ($featureManager as $feature) {
            if ($this->isExpired($feature)) {
                if ($sendWarnings) {
                    $this->sendFeatureMail($feature, 'alert_email');
                }
                $output->writeln($this->renderTemplate($feature, 'alert_console'));

                if ($dieOnExpired) {
                    $output->writeln('Feature check stopped!');
                    return self::EXPIRED_FEATURE_CODE;
                }
            } elseif ($this->isGoingToExpire($feature, $expirationWarning)) {
                if ($sendWarnings) {
                    $this->sendFeatureMail($feature, 'warning_email');
                }
                $output->writeln($this->renderTemplate($feature, 'warning_console'));
            }
        }

        $output->writeln('Feature check is done!');
        return 0;
    }

    /**
     * @param FeatureInterface $feature
     * @return bool
     */
    private function isExpired(FeatureInterface $feature) {
        if (!$feature->getExpiration()) {
            return false;
        }

        $now = new \DateTime();
        return $feature->getExpiration() < $now;
    }

    /**
     * @param FeatureInterface $feature
     * @param int $threshold
     * @return bool
     */
    private function isGoingToExpire(FeatureInterface $feature, $threshold) {
        if (!$feature->getExpiration()) {
            return false;
        }

        $warningDate = new \DateTime("$threshold day");
        return $feature->getExpiration() < $warningDate;
    }

    /**
     * Sends an e-mail about a feature
     *
     * @param FeatureInterface $feature
     * @param string $templateName
     */
    private function sendFeatureMail(FeatureInterface $feature, $templateName) {
        if (!$feature->getResponsibleEmail()) {
            return;
        }

        $mailer = $this->getContainer()->get('mailer');
        $message = $mailer->createMessage();
        $message
            ->setSubject($this->getContainer()->getParameter('rutkai_feature_flipper.email.subject'))
            ->setFrom($this->getContainer()->getParameter('rutkai_feature_flipper.email.from'))
            ->setTo($feature->getResponsibleEmail())
            ->setBody($this->renderTemplate($feature, $templateName), 'text/plain');

        $mailer->send($message);
    }

    /**
     * @param FeatureInterface $feature
     * @param string $templateName
     * @return string
     */
    private function renderTemplate(FeatureInterface $feature, $templateName) {
        $template = $this->getContainer()->getParameter("rutkai_feature_flipper.template.$templateName");
        return $this->getContainer()->get('templating')->render($template, array(
            'feature' => $feature,
        ));
    }

    /**
     * @param InputInterface $input
     * @return int
     */
    private function getExpirationWarning(InputInterface $input) {
        $expirationWarning = $input->getOption('expiration-warning');

        if ($expirationWarning === null) {
            $expirationWarning = $this->getContainer()->getParameter('rutkai_feature_flipper.expiration_warning');
        }

        return $expirationWarning;
    }

}