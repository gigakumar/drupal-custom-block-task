<?php 

namespace Drupal\custom_block\Plugin\Block; 
use Drupal\Core\Block\BlockBase; 
use Drupal\Core\Plugin\ContainerFactoryPluginInterface; 
use Symfony\Component\DependencyInjection\ContainerInterface; 
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/** * custom block arush infotech assignment . 
 * * * @Block( * id = "My_custom_block", 
 * * admin_label = @Translation("Hello  Arush Info tech "), 
 * ) 
 */ 

class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface { 

 

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ) 
  { parent::__construct($configuration, $plugin_id, $plugin_definition); 
     } 

    /** * {@inheritdoc} */ 

/*
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
   { return new static( $configuration,
    $plugin_id,
   $plugin_definition,
   );
  } 
to use in case of service dependency injection 

*/




/** * {@inheritdoc} */ 

public function build() {
$config = $this->getConfiguration();
if (!empty($config['image'][0])) {
$file =File::load($config['image'][0]);
$path = $file->createFileUrl();
//dd($path);
}
$build['content'] = [

'#title' => $config['title'],
'#image' => $path,
'#description' => $config['description']['value'],
'#background' => $config['background_select'],
'#color' => $config['color'],
'#theme' => 'custom-block',
];

return $build;
}



/** * {@inheritdoc} */ 
public function blockForm($form, FormStateInterface $form_state) {
 $config = $this->getConfiguration(); 
	
$form['title'] = [
  '#type' => 'textfield',
  '#title' => $this->t('Title'),
  '#default_value' => $config['title'],
  '#maxlength' => 128,
  '#required' => TRUE,
];


  $form['color'] = [
       '#type' => 'color',
        '#title' => $this->t('Color'),
  '#default_value' => '#ffffff',
];

$form['description'] = [

'#type'=>'text_format',
'#title' => $this->t('Description'),
'#rows' => 20,
'#default_value' => $config['description']['value'],
'#format'=>'filtered_html',
];

$form['background_select'] = [
  '#type' => 'select',
  '#title' => $this
    ->t('choose background color and image'),
  '#options' => [
    'color' => $this
      ->t('color'),
    'image' => $this
      ->t('image'),
 ]     
];

 
$form['image'] = [
      '#title' => t('picture'),
      '#description' => $this->t('Chossir Image gif png jpg jpeg'),
      '#type' => 'managed_file',
      '#required' => true,
      '#default_value'=>[$config['image'][0]],
      '#upload_location' => 'public://images/',
      '#upload_validators' => array(
        'file_validate_extensions' => array('gif png jpg jpeg')),
    ];



return $form; 

    }

/** * {@inheritdoc} */ public function blockSubmit($form, FormStateInterface $form_state) { 
 //dd($form_state->getValue('image'));

$this->configuration['title'] = $form_state->getValue('title');
$this->configuration['color'] = $form_state->getValue('color'); 
$this->configuration['description'] = $form_state->getValue('description'); 

$this->configuration['image'] = $form_state->getValue('image');

$this->configuration['background_select'] = $form_state->getValue('background_select');




} 
}



?>
