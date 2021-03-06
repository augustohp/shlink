<?php
namespace Shlinkio\Shlink\Rest\Action;

use Acelaya\ZsmAnnotatedServices\Annotation\Inject;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Shlinkio\Shlink\Core\Exception\InvalidShortCodeException;
use Shlinkio\Shlink\Core\Service\ShortUrlService;
use Shlinkio\Shlink\Core\Service\ShortUrlServiceInterface;
use Shlinkio\Shlink\Rest\Util\RestUtils;
use Zend\Diactoros\Response\JsonResponse;
use Zend\I18n\Translator\TranslatorInterface;

class EditShortcodeTagsAction extends AbstractRestAction
{
    /**
     * @var ShortUrlServiceInterface
     */
    private $shortUrlService;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * EditShortcodeTagsAction constructor.
     * @param ShortUrlServiceInterface $shortUrlService
     * @param TranslatorInterface $translator
     * @param LoggerInterface|null $logger
     *
     * @Inject({ShortUrlService::class, "translator", "Logger_Shlink"})
     */
    public function __construct(
        ShortUrlServiceInterface $shortUrlService,
        TranslatorInterface $translator,
        LoggerInterface $logger = null
    ) {
        parent::__construct($logger);
        $this->shortUrlService = $shortUrlService;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @param DelegateInterface $delegate
     * @return null|Response
     * @throws \InvalidArgumentException
     */
    public function process(Request $request, DelegateInterface $delegate)
    {
        $shortCode = $request->getAttribute('shortCode');
        $bodyParams = $request->getParsedBody();

        if (! isset($bodyParams['tags'])) {
            return new JsonResponse([
                'error' => RestUtils::INVALID_ARGUMENT_ERROR,
                'message' => $this->translator->translate('A list of tags was not provided'),
            ], self::STATUS_BAD_REQUEST);
        }
        $tags = $bodyParams['tags'];

        try {
            $shortUrl = $this->shortUrlService->setTagsByShortCode($shortCode, $tags);
            return new JsonResponse(['tags' => $shortUrl->getTags()->toArray()]);
        } catch (InvalidShortCodeException $e) {
            return new JsonResponse([
                'error' => RestUtils::getRestErrorCodeFromException($e),
                'message' => sprintf($this->translator->translate('No URL found for short code "%s"'), $shortCode),
            ], self::STATUS_NOT_FOUND);
        }
    }
}
