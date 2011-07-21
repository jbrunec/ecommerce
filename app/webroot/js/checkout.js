/**
 * 
 */

function setPaymentInfo(isChecked)
{
	with (window.document.formCheckout) {
		if (isChecked) {
			OrderOdPaymentFirstName.value  = OrderOdShippingFirstName.value;
			OrderOdPaymentLastName.value   = OrderOdShippingLastName.value;
			OrderOdPaymentAddress.value   = OrderOdShippingAddress.value;
			OrderOdPaymentCity.value   = OrderOdShippingCity.value;
			OrderOdPaymentPhoneNumber.value      = OrderOdShippingPhoneNumber.value;
			OrderOdPaymentPostalCode.value      = OrderOdShippingPostalCode.value;			
			//OrderOdPaymentCost.value       = txtShippingCity.value;
			
			OrderOdPaymentFirstName.readOnly  = true;
			OrderOdPaymentLastName.readOnly   = true;
			OrderOdPaymentAddress.readOnly   = true;
			OrderOdPaymentCity.readOnly   = true;
			OrderOdPaymentPhoneNumber.readOnly      = true;
			OrderOdPaymentPostalCode.readOnly      = true;			
		
		} else {
			OrderOdPaymentFirstName.readOnly  = false;
			OrderOdPaymentLastName.readOnly   = false;
			OrderOdPaymentAddress.readOnly   = false;
			OrderOdPaymentCity.readOnly   = false;
			OrderOdPaymentPhoneNumber.readOnly      = false;
			OrderOdPaymentPostalCode.readOnly      = false;					
		}
	}
}

function toggleStatus() {
    if ($('#OrderPaymentOption2').is(':checked')) {
        $('#elementsToOperateOn :input').attr('disabled', true);
    } else {
        $('#elementsToOperateOn :input').removeAttr('disabled');
    }   
}