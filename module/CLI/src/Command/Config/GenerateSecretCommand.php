<?php
namespace Shlinkio\Shlink\CLI\Command\Config;

use Acelaya\ZsmAnnotatedServices\Annotation\Inject;
use Shlinkio\Shlink\Common\Util\StringUtilsTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\I18n\Translator\TranslatorInterface;

class GenerateSecretCommand extends Command
{
    use StringUtilsTrait;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * GenerateCharsetCommand constructor.
     * @param TranslatorInterface $translator
     *
     * @Inject({"translator"})
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        parent::__construct(null);
    }

    public function configure()
    {
        $this->setName('config:generate-secret')
             ->setDescription($this->translator->translate(
                 'Generates a random secret string that can be used for JWT token encryption'
             ));
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $secret = $this->generateRandomString(32);
        $output->writeln($this->translator->translate('Secret key:') . sprintf(' <info>%s</info>', $secret));
    }
}
