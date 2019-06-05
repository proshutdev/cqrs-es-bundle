<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/3/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Infrastructure\Persistence\Service;

use Elasticsearch\ClientBuilder;
use Proshut\CQRSBundle\Exception\ElasticSearchReadModelPersistenceException;

/**
 * Description of ElasticSearchClientService
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ElasticSearchClientService {

    private $clientBuilder;
    public const INDEX = 'proshut';

    public function __construct( ClientBuilder $clientBuilder ) {
        $this->clientBuilder = $clientBuilder;
    }

    public function create() {
        return $this->clientBuilder::create()->setHosts([ [ 'host' => $_ENV[ 'ELASTICSEARCH_HOST' ],
                                                            'port' => $_ENV[ 'ELASTICSEARCH_PORT' ] ] ])->build();
    }

    public function index( array $params ) {
        $Client = $this->create();
        $Client->index($params);
        $Result = $Client->index($this->params);
        if ($Result[ '_shards' ][ 'successful' ] < 1) {
            throw new ElasticSearchReadModelPersistenceException('error.readmodel.global.persistence');
        }
    }

    public function search( array $params ) {
        $Cleint = $this->create();
        $Result = $Cleint->search($params);
        var_dump($Result);
        die();
    }
}