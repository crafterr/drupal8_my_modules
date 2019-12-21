<?php

namespace Drupal\typed_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\MapDataDefinition;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    $definition = DataDefinition::create('string');
    $definition->setLabel('Defines a simple string');

    /** @var \Drupal\Core\TypedData\TypedDataInterface $data */
    $data = \Drupal::typedDataManager()->create($definition,'my_values');

    $value = $data->getValue();
    $data->setValue('another string');

    $type = $data->getDataDefinition()->getDataType();
    $label = $data->getDataDefinition()->getLabel();
    dump($value);
    dump($type);
    dump($label);
    dump($data->getValue());
    die();
  }

  /**
   * Please modeling my licence plate and wrap it up into typeddata datadefinition
   */
  public function licencePlate()
  {
    $plateNumberDefinition = DataDefinition::create('string');
    $plateNumberDefinition->setLabel('A licence plate number');

    $stateCodeDefinition = DataDefinition::create('string');
    $stateCodeDefinition->setLabel('A state code');


    $plateDefinition = MapDataDefinition::create();
    $plateDefinition->setLabel('A US licence plate');

    $plateDefinition->setPropertyDefinition('number',$plateNumberDefinition);
    $plateDefinition->setPropertyDefinition('state', $stateCodeDefinition);

    /** @var \Drupal\Core\TypedData\Plugin\DataType\Map $plate */
    $plate = \Drupal::typedDataManager()->create($plateDefinition, ['state'=>'NY','number'=>'405-307']);

    $label = $plate->getDataDefinition()->getLabel();
    $number = $plate->get('number');
    $state = $plate->get('state');

    dump('label = ' .$label);
    dump('number_code = '.$number->getValue());
    dump('state_code = '.$state->getValue());
    dump($plate->getValue());
    //$state_code = $state->getValue()
    die();

  }

  public function zipCode()
  {

    $charDefinition = DataDefinition::create('string');
    $charDefinition->setLabel('A char number np LC');
    $charDefinition->setSettings([
      'max_length' => 2
    ]);
    $charDefinition->setRequired(true);

    $numberDefinition = DataDefinition::create('string');
    $numberDefinition->setLabel('A number definition np 44332');
    $numberDefinition->setSettings([
      'max_length' => 5
    ]);
    $numberDefinition->setRequired(true);


    $registerPlateDefinition = MapDataDefinition::create();
    $registerPlateDefinition->setLabel('A Register Plate');
    $registerPlateDefinition->setPropertyDefinition('char', $charDefinition);
    $registerPlateDefinition->setPropertyDefinition('number', $numberDefinition);

    $registerPlate = \Drupal::typedDataManager()->create($registerPlateDefinition,['char'=>'KR','number' => '5ss5448']);

    $validation = $registerPlate->validate();
    $rawData = $registerPlate->getValue();
    $data = $registerPlate->getCastedValue();
    dump($validation);
    dump($rawData);
    die();


  }

  public function complex()
  {

    $definition = DataDefinition::create('string');
    $definition->setLabel('My string definition');
    $definition->addConstraint('Length',['max'=>20]);
    $definition->addConstraint('Email');
    $definition->setRequired(true);

    $stringTypedData = \Drupal::typedDataManager()->create($definition,'');

    $stringTypedData->setValue('adam ma kota');

    $validator = $stringTypedData->validate();
   
    if ($validator->has(0)) {
      echo $validator->get(0)->getMessage();
    } else {
      dump($validator);
      echo 'idzie dalej';
    }
    die();
  }

  public function validation() {
    $definition = DataDefinition::create('string');
    $definition->addConstraint('Length', ['max' => 20]);
    /** @var \Drupal\Core\TypedData\TypedDataInterface $data */
    $data = \Drupal::typedDataManager()->create($definition, 'my value that is too long');
    $violations = $data->validate();

    /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
    foreach ($violations as $violation) {
      $message = $violation->getMessage();
      $value = $violation->getInvalidValue();
      $path = $violation->getPropertyPath();
      echo $message;
      dump($value);
      dump($path);
    }
    die();
  }

}
