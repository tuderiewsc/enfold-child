/* Version 1.0.8 */
jQuery(document).ready(function ($) {

    // Inits
    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 300, "hide": 100}
    });
    // Inits

    setInterval(function() {
        $('.dial-btn').find('i').addClass('is-animating');
        setTimeout(function() {
            $('.dial-btn').find('i').removeClass('is-animating');
        }, 2000);
    }, 12000);


    // Add Material icons
    $('.single_add_to_cart_button').html('<i class="ic-basket my-2"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');

    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-chevron-left"></i>');
    $('.trail-begin').find('span[itemprop="name"]').html('<span itemprop="name">صفحه اصلی</span>');


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');


    // Crisp Avatar
    let check_crisp = setInterval(function () {
        const crispElm =  document.getElementById('crisp-chatbox');
        if (typeof(crispElm) != 'undefined' && crispElm != null)
        {
            $('.cc-1iv2').find('.cc-15mo').remove();
            $('.cc-7doi.cc-1ada').append('<img src="https://radshid.com/wp-content/uploads/2021/03/support_avatar2.jpg" width="70" height="70" alt="">');
            clearInterval(check_crisp);
        }
    } , 300);


    // Change Sipaad phone number
    $('#product-14049').find('.woo-price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');
    $('.template-shop').find('.post-14049').find('.price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');


    // Change Shop buttons text temporary
    $('.template-shop').find('.inner_product').find('.product_type_simple').html('ادامه');
    $('.template-shop').find('.inner_product').find('.add_to_cart_button').html('<i class="ic-shopping-cart"></i>افزودن به سبد خرید');
    $('.template-shop').find('.inner_product').find('.show_details_button').html('<i class="ic-list"></i>نمایش جزئیات');
    $('.wpsp-cart-button').find('a.add_to_cart_button').html('خرید کنید');
});
