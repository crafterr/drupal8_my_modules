<?php

namespace Drupal\data_storage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  protected $tempStore;

  // Pass the dependency to the object constructor
  public function __construct(PrivateTempStoreFactory $temp_store_factory) {
    // For "mymodule_name," any unique namespace will do
    $this->tempStore = $temp_store_factory->get('mymodule_name');
  }

  // Uses Symfony's ContainerInterface to declare dependency to be passed to constructor
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.private_tempstore')
    );
  }

  public function stateApi() {

    /**
     * @var StateInterface $state
     */
   $this->state()->set('my_unique_key_name','adam ma kota');

   //dump($this->state()->get('my_unique_key_name'));

  // $this->state()->delete('my_unique_key_name');

   //multiple
    $this->state()->setMultiple(['my_unique_key_one' => 'value', 'my_unique_key_two' => 'value']);
    //dump($this->state()->getMultiple(['my_unique_key_one', 'my_unique_key_two']));

    $this->state()->deleteMultiple(['my_unique_key_one', 'my_unique_key_two']);

    //set in key_value table collection = state name my_unique_key
   return new Response();
  }

  public function tempStore() {
    /**
     * PRIVATE TEMPSTORE  FOR USER
     */
    /** @var \Drupal\Core\TempStore\PrivateTempStoreFactory $factory */
    $factory = \Drupal::service('user.private_tempstore');
    $store = $factory->get('data_storage.my_collection');
    $store->set('my_key','adam ma kota');
    $value = $store->get('my_key');

    //set in key_value_expire table name id_user:my_key 1:my_key value bloob  O:8:"stdClass":3:{s:5:"owner";s:1:"1";s:4:"data";s:12:"adam ma kota";s:7:"updated";i:1574372368;}
    //if user is not authorized then id_user will be 4W2kLm0ovYlBneHMKPBUPdEM8GEpjQcU3_-B3X6nLh0:my_key
    //Lastly, we have the expire column, which, by default, will be one week from the moment the entry was created. This is a "global" timeframe set as a parameter in the user.services.yml
   // dump($value);
    $metadata = $store->getMetadata('my_key');
   // dump($metadata);
    //we can delete
    //$store->delete('my_key');


    /**
     * SHARED TEMPSTORE WORK
     */

    /** @var \Drupal\Core\TempStore\SharedTempStoreFactory $factory */
    $factory = \Drupal::service('user.shared_tempstore');
    $store = $factory->get('my_module.my_collection');
    $store->set('my_key', 'my_value');
    $value = $store->get('my_key');
    //dump($value);

    $metadata = $store->getMetadata('my_key');
    //$store->delete('my_key');
    $store->setIfOwner('my_key','my_valueeee');
    $value = $store->get('my_key');
   // dump($value);
    return new Response();

  }


  /**
   *  if you need to store something more irregular, such as user preferences or flag that a given user has done something, the UserData is a good place to do that.
   */
  public function userData() {
    /** @var \Drupal\user\UserDataInterface $userData */
    $userData = \Drupal::service('user.data');
    $userData->set('data_storage',$this->currentUser()->id(),'var','Adam ma kota');
    $s = $userData->get('data_storage',$this->currentUser()->id(),'var');
    /**
     * The user module defines the users_data database table whose columns pretty much map to the arguments of these methods. The extra serialized column is there to indicate whether the stored data is serialized. Also, in this table, multiple records for a given user can coexist.
     */
    //dump($s);
    return new Response();
  }

  public function bibliography() {
    $tempstore = \Drupal::service('user.private_tempstore')->get('data_storage');
    $tempstore->set('key_name', 'adam ma kota');
    $value = $tempstore->get('key_name');

    die();
  }

  public function bibliographyRead() {
    /** @var \Drupal\Core\TempStore\PrivateTempStoreFactory $factory */
    $tempstore = \Drupal::service('user.private_tempstore')->get('data_storage');
    //$tempstore->set('key_name', 'adam ma kota');
    $value = $tempstore->get('key_name');

    die();
  }

}
