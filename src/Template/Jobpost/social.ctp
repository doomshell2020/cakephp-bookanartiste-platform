<?php 


echo $this->SocialShare->fa(
    'facebook',
    'https://www.bookanartiste.com/applyjob/10'
);

$services = [
    'facebook' => __('Share on Facebook'),
    'gplus' => __('Share on Google+'),
    'linkedin' => __('Share on LinkedIn'),
    'twitter' => __('Share on Twitter')
];

echo '<ul>';
foreach ($services as $service => $linkText) {
    echo '<li>' . $this->SocialShare->link(
        $service,
        $linkText
    ) . '</li>';
}
echo '</ul>';

?>