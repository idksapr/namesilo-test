<?php

namespace App\Controllers;

use App\Controllers\Dtos\DomainDto;
use App\Controllers\Params\GetDomainPricesParams;
use App\Domains\Repositories\TldRepository;
use App\Domains\Repositories\DomainRepository;
use App\Utils\Domains;
use App\Utils\ObjectArrays;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class DomainsController extends Controller
{
    /**
     * @var TldRepository
     */
    private $_tldRepository;

    /**
     * @var DomainRepository
     */
    private $_domainRepository;

    /**
     * DomainsController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @param TldRepository $tldRepository
     * @param DomainRepository $domainRepository
     */
    public function __construct($id, $module, $config = [],
                                TldRepository $tldRepository, DomainRepository $domainRepository) {
        parent::__construct($id, $module, $config);

        $this->_tldRepository = $tldRepository;
        $this->_domainRepository = $domainRepository;
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    /**
     * Get domain with prices
     *
     * @return DomainDto[]
     * @throws BadRequestHttpException
     */
    public function actionCheck(): array
    {
        $params = new GetDomainPricesParams();
        if (!$params->load(Yii::$app->request->get(), '') || !$params->validate()) {
            throw new BadRequestHttpException();
        }

        // todo найти список tld из таблицы
        // todo создать список доменов
        // todo проверить домены на корректность имени
        // todo проверить наличие домена в таблице domain
        // todo создать список dto с ценами для списка доменов

        $name = $params['search'];
        $tlds = $this->_tldRepository->findAll();

        $domains = ObjectArrays::filter(
            Domains::fromNameAndTlds($name, array_column($tlds, 'tld')),
            function ($domain) {
                return Domains::valid($domain);
            }
        );

        if (empty($domains)) {
            throw new BadRequestHttpException();
        }

        $existingDomains = array_column($this->_domainRepository->findAllByDomains($domains), 'domain');

        /** @var DomainDto[] $dtos */
        $dtos = array_map(
            function ($domain) use ($tlds, $name, $existingDomains) {
                $tld = ObjectArrays::filterEqualOne(
                    $tlds,
                    'tld',
                    Domains::getTldFromDomainByName($domain, $name)
                );
                return new DomainDto(
                    $tld->tld,
                    $domain,
                    $tld->price,
                    !in_array($domain, $existingDomains)
                );
            },
            $domains
        );

        return $dtos;
    }
}
