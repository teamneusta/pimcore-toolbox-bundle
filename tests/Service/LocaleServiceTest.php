<?php declare(strict_types=1);

namespace Neusta\Pimcore\ToolboxBundle\Tests\Service;

use Neusta\Pimcore\ToolboxBundle\Service\LocaleService;
use Neusta\Pimcore\ToolboxBundle\Wrapper\Admin;
use Neusta\Pimcore\ToolboxBundle\Wrapper\Tool;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class LocaleServiceTest extends TestCase
{
    use ProphecyTrait;

    private LocaleService $localeService;

    /** @var ObjectProphecy<RequestStack> */
    private ObjectProphecy $requestStack;
    /** @var ObjectProphecy<Tool> */
    private ObjectProphecy $pimcoreTool;
    /** @var ObjectProphecy<Admin> */
    private ObjectProphecy $pimcoreToolAdmin;

    protected function setUp(): void
    {
        $this->requestStack = $this->prophesize(RequestStack::class);
        $this->pimcoreTool = $this->prophesize(Tool::class);
        $this->pimcoreToolAdmin = $this->prophesize(Admin::class);

        $this->localeService = new LocaleService(
            $this->requestStack->reveal(),
            $this->pimcoreTool->reveal(),
            $this->pimcoreToolAdmin->reveal(),
            'de',
        );
    }

    public function samplesForRequestLocale()
    {
        yield 'Valid locale by request' => ['en', true, 'en', null];
        yield 'Invalid locale by request' => ['fr', false, 'en', 'fr'];
        yield 'No default locale by Pimcore' => ['de', false, 'en', null];
    }

    /**
     * @dataProvider samplesForRequestLocale
     */
    public function testGetLocaleByRequest(string $expectedLocale, bool $valid, ?string $requestLocale, ?string $pimcoreDefaultLocale): void
    {
        $requestMock = $this->prophesize(Request::class);
        $requestMock->getLocale()->willReturn($requestLocale);

        $this->pimcoreTool->isValidLanguage($requestLocale)->willReturn($valid);

        $this->requestStack->getMainRequest()->willReturn($requestMock->reveal());

        $this->pimcoreTool->getDefaultLanguage()->willReturn($pimcoreDefaultLocale);

        $localeByRequest = $this->localeService->getLocaleByRequest();
        self::assertEquals($expectedLocale, $localeByRequest);
    }

    public function samplesForUserLocale()
    {
        yield 'Locale by user' => ['en', true, 'en', null];
        yield 'Locale by Pimcore default' => ['fr', false, 'en', 'fr'];
        yield 'Locale by default' => ['de', false, 'en', null];
    }

    /**
     * @dataProvider samplesForUserLocale
     */
    public function testGetLocaleByAdminUser(string $expectedLocale, bool $valid, ?string $userLocale, ?string $defaultPimcoreLocale): void
    {
        $this->pimcoreToolAdmin->getCurrentUserLanguage()->willReturn($userLocale);

        $this->pimcoreTool->getDefaultLanguage()->willReturn($defaultPimcoreLocale);

        $this->pimcoreTool->isValidLanguage($userLocale)->willReturn($valid);

        $localeByRequest = $this->localeService->getLocaleByAdminUser();
        self::assertEquals($expectedLocale, $localeByRequest);
    }
}
