<?php

namespace App\Controllers;

use App\Controllers\Dtos\DomainDto;
use App\Controllers\Params\GetDomainPricesParams;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class DomainsController extends Controller
{
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

        /** @var DomainDto[] $dtos */
        $dtos = [];
        return $dtos;
    }
}
