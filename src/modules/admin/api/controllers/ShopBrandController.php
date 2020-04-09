<?php

namespace app\modules\admin\api\controllers;

use app\core\models\shop\ShopBrand;
use app\modules\admin\api\Controller;
use app\modules\admin\api\models\ShopBrandSearchForm;
use yii\web\NotFoundHttpException;

class ShopBrandController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->getRequest()->setQueryParams(['expand' => 'shopCategories.parents']);

        $form = new ShopBrandSearchForm();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionView($id)
    {
        $shopBrand = $this->getShopBrandById($id);

        return $shopBrand->toArray([], ['shopCategories.parents']);
    }

    private function getShopBrandById($id)
    {
        /* @var $shopBrand ShopBrand|null */
        $shopBrand = ShopBrand::find()->where(['id' => $id])->one();

        if ($shopBrand == null) {
            throw new NotFoundHttpException('商品品牌不存在');
        }

        return $shopBrand;
    }

    public function actionCreate()
    {
        $shopBrand = new ShopBrand();
        $shopBrand->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopBrand->save()) {
            return $shopBrand;
        }

        return $shopBrand->toArray([], ['shopCategories.parents']);
    }

    public function actionEdit($id)
    {
        $shopBrand = $this->getShopBrandById($id);
        $shopBrand->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$shopBrand->save()) {
            return $shopBrand;
        }

        return $shopBrand->toArray([], ['shopCategories.parents']);
    }

    public function verbs()
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'view' => ['GET'],
            'edit' => ['PUT'],
            'delete' => ['DELETE'],
        ];
    }
}
