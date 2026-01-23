<?php
$user_id = $this->request->session()->read('Auth.User.id');
$url = $this->request->here();
$visitor_id = trim($url, "/viewgalleries/");

$galleryImages = $this->Comman->galleryImagesCount();
// pr($galleryImages);exit;

// Define gallery items
$galleryItems = [
  [
    'type' => 'Photos',
    'action' => ['viewgalleries', 'viewimages'],
    'url' => SITE_URL . "/viewgalleries/" . $profile->user_id,
    'count' => count($singleimages) + $galleryImages,
    'condition' => $total_photos > 0
  ],
  [
    'type' => 'Video',
    'action' => ['viewvideos'],
    'url' => SITE_URL . "/viewvideos/" . $profile->user_id,
    'count' => count($videos),
    'condition' => $total_videos > 0
  ],
  [
    'type' => 'Audio',
    'action' => ['viewaudios'],
    'url' => SITE_URL . "/viewaudios/" . $profile->user_id,
    'count' => count($audios),
    'condition' => $total_audios > 0
  ]
];
?>

<ul class="nav nav-pills gall-tab">
  <?php
  $hasContent = false;
  foreach ($galleryItems as $item) {
    if ($item['condition']) {
      $hasContent = true;
      $isActive = in_array($this->request->params['action'], $item['action']);
  ?>
      <li class="<?php echo $isActive ? 'active' : ''; ?>">
        <a href="<?php echo $item['url']; ?>" class="">
          <?php echo $item['type']; ?> (<?php echo $item['count']; ?>)
        </a>
      </li>
  <?php
    }
  }

  // Add "Manage Gallery" link if any gallery section is empty
  //if (!$hasContent) { 
  ?>
  <li>
    <a href="<?php echo SITE_URL; ?>/galleries" class="">Manage Gallery</a>
  </li>
  <?php //} 
  ?>
</ul>