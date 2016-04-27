<div class="col-xs-12 col-sm-6">
    <div class="area-title">
        <h3><?=$promo->name?></h3>
    </div>
    <div class="camera-area">
        <div class="row">
            <div class="camera-slide featured-product-area">
                <?php foreach($promo->shoes as $shoes):?>
                <div class="featured-inner">
                    <div class="featured-image">
                        <a href="single-product.html">
                            <img src="<?=$shoes->mainImage->thumbnailURL(250, 250)?>" alt="">
                        </a>
                        <span class="price-percent-reduction">-20%</span>
                    </div>
                    <div class="featured-info">
                        <a href="single-product.html"><?=$shoes->name?></a>
                        <span class="price"><?=$shoes->price?></span>
                        <div class="featured-button">
                            <a href="cart.html" class="add-to-card"><i class="fa fa-shopping-cart"></i>Купить</a>
                        </div>
                    </div>
                </div>
                <?php endforeach?>
            </div>
        </div>
    </div>
</div>