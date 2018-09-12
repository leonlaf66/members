<?php
namespace module\core\components\graphql;

use Exception;

class Client extends \yii\base\Component
{
    public $baseUrl = '';
    public $appToken = null;

    protected $_client = null;

    public function init()
    {
        $this->_client = new \EUAutomation\GraphQL\Client($this->baseUrl);
    }

    public function request($gqlId, $variables = [], $headers = [], $defValue = null)
    {
        $headers = array_merge($headers, [
            'app-token' => $this->appToken,
            'language' => \yii::$app->language,
            'area-id' => \WS::$app->area->id
        ]);
        if (!\WS::$app->user->isGuest) {
            $headers['access-token'] = \WS::$app->user->identity->access_token;
        }

        $query = $this->getGraphqlQuery($gqlId);
        $response = null;
        try {
            $response = $this->_client->response($query, $variables, $headers);
        } catch(\Exception $e) {
            throw new Exception($e->getMessage(), 400, $e);
        }
        if ($response->hasErrors()) {
            var_dump($response->errors());exit;
            $error = $response->errors()[0];
            throw new Exception('SERVICE-ERROR:'.$error->message, 401);
        }

        return $response->all();
    }

    private function getGraphqlQuery($gqlId)
    {
        return file_get_contents(\yii::$app->controller->module->basePath . '/gql/' . $gqlId . '.gql');
    }
}