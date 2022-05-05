<?php declare(strict_types=1);

namespace EcomwiseNofollowNoindex\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Storefront\Page\MetaInformation;
use Shopware\Storefront\Page\GenericPageLoadedEvent;
use Shopware\Storefront\Page\Search\SearchPageLoadedEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class GenericPageSubscriber implements EventSubscriberInterface
{
    private $systemConfigService;

    public function __construct(
        SystemConfigService $systemConfigService
    )
    {
        $this->systemConfigService = $systemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            GenericPageLoadedEvent::class => ['setNoindexNofollow', 1000],
            SearchPageLoadedEvent::class => ['setNoindexNofollowSearchPage', 1000],
        ];
    }

    public function setNoindexNofollow(GenericPageLoadedEvent $event): void
    {
        if($this->systemConfigService->get('EcomwiseNofollowNoindex.config.enableNoindexNofollow', $event->getSalesChannelContext()->getSalesChannelId())){
            $page = $event->getPage();
            $page->setMetaInformation((new MetaInformation())->assign([
                'robots' => 'noindex,nofollow',
            ]));
        }
    }

    public function setNoindexNofollowSearchPage(SearchPageLoadedEvent $event): void
    {
        if($this->systemConfigService->get('EcomwiseNofollowNoindex.config.enableNoindexNofollow', $event->getSalesChannelContext()->getSalesChannelId())){
            $page = $event->getPage();
            $page->setMetaInformation((new MetaInformation())->assign([
                'robots' => 'noindex,nofollow',
            ]));
        }
    } 
}
