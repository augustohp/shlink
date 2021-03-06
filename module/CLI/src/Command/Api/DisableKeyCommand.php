<?php
namespace Shlinkio\Shlink\CLI\Command\Api;

use Acelaya\ZsmAnnotatedServices\Annotation\Inject;
use Shlinkio\Shlink\Rest\Service\ApiKeyService;
use Shlinkio\Shlink\Rest\Service\ApiKeyServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\I18n\Translator\TranslatorInterface;

class DisableKeyCommand extends Command
{
    /**
     * @var ApiKeyServiceInterface
     */
    private $apiKeyService;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * DisableKeyCommand constructor.
     * @param ApiKeyServiceInterface|ApiKeyService $apiKeyService
     * @param TranslatorInterface $translator
     *
     * @Inject({ApiKeyService::class, "translator"})
     */
    public function __construct(ApiKeyServiceInterface $apiKeyService, TranslatorInterface $translator)
    {
        $this->apiKeyService = $apiKeyService;
        $this->translator = $translator;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('api-key:disable')
             ->setDescription($this->translator->translate('Disables an API key.'))
             ->addArgument('apiKey', InputArgument::REQUIRED, $this->translator->translate('The API key to disable'));
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $apiKey = $input->getArgument('apiKey');

        try {
            $this->apiKeyService->disable($apiKey);
            $output->writeln(sprintf(
                $this->translator->translate('API key %s properly disabled'),
                '<info>' . $apiKey . '</info>'
            ));
        } catch (\InvalidArgumentException $e) {
            $output->writeln(sprintf(
                '<error>' . $this->translator->translate('API key "%s" does not exist.') . '</error>',
                $apiKey
            ));
        }
    }
}
