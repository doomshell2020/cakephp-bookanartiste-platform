
<?php $user=$this->request->session()->read('user_data');
//pr($user); die;

if($hours>24){
    if($day==1){
        $msg = $day.' day';
    }else{
        $msg = $day.' days';
    }  
}else{
    $msg = $hours.' hours';
}

?>
<section id="contact_pg_sec">
    <div class="contact_pginfo_dv">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact_infobx">
                        <!-- <i class="fa fa-map-marker" aria-hidden="true"></i> -->
                            <!-- <h4>Address</h4>
                            <p>Jalan Petitenget, Seminyak - Bali Indonesia 80311 (Opposite Neo Hotel, Near The Jalan Batu Belig Intersection</p> -->

                            Hello <?php echo $user['user_name']; ?> welcome to www.bookanartiste.com, a global community of creatives, individuals and organisations in the field of Performing Arts. The aim of the portal is to promote collaborative work and generate work opportunities. 

We appreciate our members for their patronage, as a result of that we would like all of us to follow stipulated norms. Your profile has been reported by fellow members quite a few times, hence you will be able to access your account in <?php echo $msg; ?> automatically
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>


<style>
    p {
    font-size: 18px;
    font-weight: 400;
    color: #58595b;
    text-align: left;
    margin-left: 8%;
}
    </style>