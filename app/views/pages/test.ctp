<?php

// Include Google Checkout PHP Client Library
include ("GlobalAPIFunctions.php");
include ("CheckoutAPIFunctions.php");

/**
* Build XML for items in the shopping cart. The shopping cart
* has the following structure:
*
* <shopping-cart>
*     <items>
*         <item>
*             <item-name>Dry Food Pack AA1453</item-name>
*             <item-description>A pack of nutritious food.</item-description>
*             <quantity>1</quantity>
*             <unit-price currency="USD">35.00</unit-price>
*             <tax-table-selector>food</tax-table-selector>
*             <merchant-private-item-data>
*             <item-note>Product Number N15037124531</item-note>
*             </merchant-private-item-data>
*         </item>
*         <!-- More items may be included using the same XML structure -->
*     </items>
* </shopping-cart>
*/

/*
* The XML for an individual item is created by defining data fields
* for the item and then calling the CreateItem() function, which
* is in the CheckoutAPIFunctions.php file.
*
* +++ CHANGE ME +++
* You will need to modify calls to functions like CreateItem,
* AddAllowedAreas, AddExcludedAreas, CreateFlatRateShipping and
* numerous others in this file to reflect the items in the 
* customer's shopping cart, the shipping options available for
* those items and the tax tables that you use to calculate taxes.
*/

// Specify item data and create an item to include in the order
$item_name = "Dry Food Pack AA1453"; 
$item_description = "A pack of highly nutritious dried food for emergency.";
$quantity = "1";
$unit_price = "35.00";
$tax_table_selector = "food";
$merchant_private_item_data = "";
CreateItem($item_name, $item_description, $quantity, $unit_price, 
    $tax_table_selector, $merchant_private_item_data);

// Specify item data and create a second item to include in the order
$item_name = "MegaSound 2GB MP3 Player";
$item_description = "Portable MP3 player - stores 500 songs, easy-to-use.";
$quantity = "1";
$unit_price = "178.00";
$tax_table_selector = "";
$merchant_private_item_data = 
    "<item-note>Product Number N15037124531</item-note>";
CreateItem($item_name, $item_description, $quantity, $unit_price, 
    $tax_table_selector, $merchant_private_item_data);

// Specify an expiration date for the order and build <shopping-cart>
$cart_expiration = "2006-12-31T23:59:59";
$merchant_private_data = 
    "<merchant-note>My order number 9876543</merchant-note>";
CreateShoppingCart($cart_expiration, $merchant_private_data);

// Create list of areas where a particular shipping option is available
$allowed_country_area = "ALL";    // OR: "CONTINENTAL_48", "FULL_50_STATES"
$allowed_state = array();        // Ex: array("CA", "NY", "DC", "NC")
$allowed_zip = array();        // Ex: array("94043", "94086", "91801", "91362")
$shipping_restrictions = AddAllowedAreas($allowed_country_area, 
    $allowed_state, $allowed_zip);

// Create list of areas where a particular shipping option is not available
$excluded_country_area = "";
$excluded_state = array("AL", "MA", "MT", "WA");
$excluded_zip = array();
$shipping_restrictions = AddExcludedAreas($excluded_country_area, 
    $excluded_state, $excluded_zip);

// Create a <flat-rate-shipping> option with shipping restrictions
$name = "UPS Ground";
$price = "8.50";
CreateFlatRateShipping($name, $price, $shipping_restrictions);

/*
* The call to the CreateMerchantCalculatedShipping function is commented out 
* because a shopping cart can not contain a <merchant-calculated-shipping> 
* option as well as other types of shipping options. 
* To use <merchant-calculated-shipping> options with this demo, you would 
* need to uncomment the next four lines of code and also comment out the 
* calls to the CreateFlatRateShipping and CreatePickup functions.
*
* $name = "SuperShip";
* $price = "10.00";
* $shipping_restrictions = "";
* CreateMerchantCalculatedShipping($name, $price, $shipping_restrictions);
*/

// Create a <pickup> shipping option
$name = "Pickup";
$price = "0.00";
CreatePickup($name, $price);

/*
* Create tax tables for the order. Tax tables have the
* following XML structure:
* <tax-tables>
*     <default-tax-table>
*         <tax-rules>
*             <default-tax-rule>
*                 <shipping-taxed>true</shipping-taxed>
*                 <rate>0.0825</rate>
*                 <tax-area>
*                     <!-- could also contain country or zip areas>
*                     <us-state-area>
*                         <state>NY</state>
*                     </us-state-area>
*                 </tax-area>
*             </default-tax-rule>
*         </tax-rules>
*     </default-tax-table>
*     <alternate-tax-tables>
*         <alternate-tax-table>
*             <alternate-tax-rules>
*                 <alternate-tax-rule>
*                     <rate>0.0825</rate>
*                     <tax-area>
*                         <!-- could also contain country or zip areas>
*                         <us-state-area>
*                             <state>NY</state>
*                         </us-state-area>
*                     </tax-area>
*                 </alternate-tax-rule>
*             </alternate-tax-rules>
*         </alternate-tax-table>
*     </alternate-tax-tables>
* </tax-tables>
*
* +++ CHANGE ME +++
* You will need to update the tax tables to match those
* used to calculate taxes for your store
*/

$rate = "0.0825";
$tax_area_country = "ALL";
$tax_area = CreateTaxArea("country", $tax_area_country);
$shipping_taxed = "false";
CreateDefaultTaxRule($rate, $tax_area, $shipping_taxed);
    
$rate = "0.0800";
$tax_area_state = "NY";
$tax_area = CreateTaxArea("state", $tax_area_state);
$shipping_taxed = "true";
CreateDefaultTaxRule($rate, $tax_area, $shipping_taxed);
    
$rate = "0.0225";
$tax_area_state = "CA";
$tax_area = CreateTaxArea("state", $tax_area_state);
CreateAlternateTaxRule($rate, $tax_area);

$rate = "0.0200";
$tax_area_state = "NY";
$tax_area = CreateTaxArea("state", $tax_area_state);
CreateAlternateTaxRule($rate, $tax_area);
                    
$standalone = "false";
$name = "food";
CreateAlternateTaxTable($standalone, $name);

$rate = "0.0500";
$tax_area_country = "FULL_50_STATES";
$tax_area = CreateTaxArea("country", $tax_area_country);
CreateAlternateTaxRule($rate, $tax_area);

$rate = "0.0600";
$tax_area_zip = "9404*";
$tax_area = CreateTaxArea("zip", $tax_area_zip);
CreateAlternateTaxRule($rate, $tax_area);

$standalone = "true";
$name = "drug";
CreateAlternateTaxTable($standalone, $name);

$merchant_calculated = "false";
CreateTaxTables($merchant_calculated);

/*
* Specify A URL to which Google Checkout should send Merchant Calculations
* API (<merchant-calculation-callback>) requests and create the
* <merchant-calculations> XML for a Checkout API request.
*
* +++ CHANGE ME +++
* If you are implementing the Merchant Calculations API, you need to
* uncomment the following lines of code, which create the
* <merchant-calculations> XML in a Checkout API response. You also
* need to update the value of the $merchant_calculations_url variable
* to the URL to which Google Checkout should send 
* <merchant-calculation-callback> requests.
*/

/*
$merchant_calculations_url = 
    "http://www.example.com/shopping/MerchantCalculationCallback.php";
$accept_merchant_coupons = "true";
$accept_gift_certificates = "true";
CreateMerchantCalculations($merchant_calculations_url, 
    $accept_merchant_coupons, $accept_gift_certificates);
*/

/*
* +++ CHANGE ME +++
* The $edit_cart_url variable identifies a URL that the customer can 
* link to to edit the contents of the shopping cart.
* The $continue_shopping_url variable identifies a URL that the
* customer can link to to continue shopping.
* If you are providing of these options to your customers, you need 
* to insert the appropriate URLs for these variables.
* e.g. $edit_cart_url = "http://www.example.com/shopping/edit";
*     $continue_shopping_url = "http://www.example.com/shop/continue";
*/

$edit_cart_url = "";
$continue_shopping_url = "";

/*
* Build the <merchant-checkout-flow-support> element in the CHeckout
* API request.
*/
CreateMerchantCheckoutFlowSupport($edit_cart_url, $continue_shopping_url);

/**
* Create the shopping cart XML and HMAC-SHA1 signatures that
* will be included in your HTTP POST request to Google Checkout 
*    1. Retrieve the shopping cart XML
*    2. Call the CalcHmacSha1 function to get the signature for cart
*    3. Base64-encode the shopping cart XML and the signature
*/

// 1. Get <checkout-shopping-cart> XML
$xml_cart = CreateCheckoutShoppingCart();

// 2. Use the cart XML and your merchant key to calculate the HMAC-SHA1 value
$signature = CalcHmacSha1($xml_cart);

// 3. Base64-encode the Cart XML and the signature before posting
$b64_cart = base64_encode($xml_cart);
$b64_signature = base64_encode($signature);

$checkout_post_data = "cart=" . urlencode($b64_cart) . "&signature=" . 
    urlencode($b64_signature);

/*
* Log the encoded XML that will be POSTED to Google Checkout
* if the customer clicks the Google Checkout button
*/
LogMessage($GLOBALS["logfile"], $checkout_post_data);

/*
* The following HTML page displays some information about the POST
* request that will be submitted to Google Checkout if you click the 
* Google Checkout button that appears on the page. The Google Checkout 
* button is embedded in a form similar to the form you want to include 
* on your site. The form sends the request to Google Checkout and shows 
* you an interface similar to what your customer would see after clicking 
* the Google Checkout button.
*
* Note: This page also calls the DisplayDiagnoseResponse function,
* which is defined in GlobalAPIFunctions.php, to verify that the 
* API request contains valid XML. If the request does not contain
* valid XML, you will see a link to a tool that lets you edit and
* recheck the XML. The code for that tool is in the 
* DebuggingTool.php file, which is also included
* in the checkout-php-samplecode.zip file.
*/

?>

    <p style="text-align:center">
    <table class="table-1" cellspacing="5" cellpadding="5">
        <tr><td style="padding-bottom:20px"><h2>
        Place a New Order
        </h2></td></tr>

        <tr><td>

            <!-- Print the steps for posting a shopping cart XML -->
            <p><b>Follow these steps to post an XML shopping cart:</b></p>
            <p><ol>
                <li>Create a <checkout-shopping-cart> XML structure
                    containing information about the buyer's order.</li>
                <li>Create an HMAC_SHA1 signature for the shopping cart.
                    The CalcHmacSha1 function in GlobalAPIFunctions.php
                    can be used to generate this signature.</li>
                <li>Base64-encode the shopping cart XML.</li>
                <li>Base64-encode the HMAC_SHA1 signature.</li>
                <li>Put the cart and signature into a form that displays
                    a Google Checkout button.</li>
            </ol></p>
            <p> </p>

            <!-- Print the shopping cart XML -->
            <p><b>1. <checkout-shopping-cart> XML:</b></p>
            <p><?php echo htmlentities($xml_cart); ?></p>
            <p> </p>

            <!-- Print the HMAC-SHA1 signature in binary -->
            <p><b>2. HMAC-SHA1 Signature:</b></p>
            <p><?php echo htmlentities($signature); ?></p>
            <p> </p>

            <!-- Print the base64-encoded shopping cart XML -->
            <p><b>3. Base64-encoded <checkout-shopping-cart> XML:</b></p>
            <p><?php echo htmlentities($b64_cart); ?></p>
            <p> </p>

            <!-- Print the base64-encoded HMAC-SHA1 signature -->
            <p><b>4. Base64-encoded HMAC-SHA1 Signature:</b></p>
            <p><?php echo htmlentities($b64_signature); ?></p>
            <p> </p>

        </td></tr>

        <!-- Print Error message if the shopping cart XML is invalid -->
        <?php
            DisplayDiagnoseResponse($checkout_post_data, 
                $GLOBALS["checkout_diagnose_url"], $xml_cart, "debug");
        ?>

        <!-- Print the Google Checkout button in a form 
             containing the shopping cart data -->
        <tr><td>
            <p><b>5. Google Checkout button form.
            Click on the button to post this cart.</b></p>

            <?php
                // Google Checkout button implementation
                $button_w = "180";
                $button_h = "46";
                $button_style = "white";
                $button_variant = "text";
                $button_loc = "en_US";
                $button_src = 
                    "https://sandbox.google.com/checkout/buttons/checkout.gif" . 
                    "?merchant_id=" . $GLOBALS["merchant_id"] . 
                    "&w=" . $button_w . 
                    "&h=" . $button_h . 
                    "&style=" . $button_style . 
                    "&variant=" . $button_variant . 
                    "&loc=" . $button_loc;
            ?>

            <p><form method="POST" 
                action="<?php echo $GLOBALS["checkout_url"]; ?>">
                <input type="hidden" name="cart" 
                value="<?php echo $b64_cart; 
                // base64-encoded <checkout-shopping-cart> XML ?>">
                <input type="hidden" name="signature" 
                value="<?php echo $b64_signature;
                // base64-encoded signature ?>">
                <input type="image" name="Checkout" alt="Checkout" 
                src="<?php echo $button_src; ?>" 
                height="<?php echo $button_h; ?>" 
                width="<?php echo $button_w; ?>">
                </form></p>
        </td></tr>
    </table>
    </p>
