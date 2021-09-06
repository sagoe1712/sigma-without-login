@extends('layouts.main')
@section('content')
    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h2>
                    Return Policy
                </h2>
            </div>
            <img src="{{asset('images/privacy-policy/return.jpg')}}" width="100%" />
        </div>

    </div>


    <div style="padding-left: 10%; padding-right: 10%;" id="tt-pageContent top-destination-container">
        <!-- Terms and Conditions -->
        <div class="terms-and-conditions">
            <h3>Sigma Prime Merchandise Returns Policy</h3>
            <ul class="terms-listing">
                <li>All return complaints must be made within 7 calendar days of receiving an item.</li>
                <li>A complaint is made by sending a mail containing the complaints about the item delivered and reasons for return to the sigmaprime@sigmapensions.com</li>
                <li>A review of the complaint will be made within 48 hours.</li>
                <li>If your complaint is valid, you will receive an authorization for return email and you will be given 5 days to return the item.</li>

            </ul>
            <h4>Requirements for a valid return procedure:</h4>
            <ul class="terms-listing">
                <li>Item should be repacked into its original packaging</li>
                <li>All other accessories that came with it should also be packed and returned with the item.</li>
                <li>Ensure that it is in its original condition</li>
                <li>Attach the delivery invoice that came with it (as proof that it was delivered by us)</li>
                <li>If the item is returned fulfilling these requirements, a mail will be sent to you to notify you when the returned item is received by us and the product assessment will begin.</li>
                <li>Our team will conduct an assessment of the product returned to make sure all complaints made are valid.</li>
                <li>If the item passes the assessment and the reasons for return are found to be valid, our team will contact you to resolve the issue either by exchanging the item with one that suits you or refund your points.  Please note that this refund will be less points deducted for shipping.</li>
                <li>Should there be any item damaged due to our transportation, please contact Sigma Call Centre within 24 hours for claim purposes. Remember to send back all items including free promotional items if any that came with the purchase. If forgotten, the return will not be accepted.</li>
            </ul>
            <p>Kindly note that the following items listed below cannot be returned if you change your mind. Item can be returned if a wrong item was delivered or if item is damaged.</p>
            <p>Desktops & Monitors, Gas cookers &oven, Fitness Machines, Baby cots & strollers, Professional Video Cameras, Grill &outdoor entertainment, Television, Furniture, Home theatre, Washing Machine &   Dryer, Projectors, Dishwashers, Musical instruments, Air conditioner &heater & hot water system, Tyres& Wheels Gas, Cooker &oven, Mower & Outdoor Power Tools, Fridge &Freezers</p>
            <p>Kindly note you can only make returns for the below categories if you receive a wrong item:</p>
            <ul class="terms-listing">
                <li>Underwear</li>
                <li>Perfume</li>

            </ul>
            <b>Conditions and reasons to return an item</b>
            <p>You may want to return your item due to any of the following reasons:</p>
            <strong><i class="red-text bold-text">x </i> Not Required</strong><br/><strong><i class="green-text bold-text">✓ </i> Required</strong>
            <div class="table-responsive">
                <table class="table table-striped" border="0" cellspacing="0" cellpadding="10" width="100%">
                    <tr style="background: #fff !important;">
                        <td width="30%" rowspan="2" style="border-right: 1px solid #cbcbcb;"><br>
                            <strong>Reasons for return</strong></td>
                        <td colspan="5"><p><strong>YOUR RETURN MUST BE : </strong></p></td>
                    </tr>
                    <tr>
                        <td><p>New condition</p></td>
                        <td width="22%"><p>Sealed condition</p></td>
                        <td><p>Complete (free gifts, accessories, original packaging)</p></td>
                        <td><p>Not damaged</p></td>
                        <td><p>Tags &amp; labels attached</p></td>
                    </tr>
                    <tr>
                        <td><p>Delivery - Wrong Product</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i><br>
                                Product sealed should not be broken EXCEPT for item type   that cannot be differentiated visually based on information provided on the   box / packaging only</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Quality - Damaged Product</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Quality - Defective</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Quality - Product Condition</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Delivery - Parts Missing</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Website - Incorrect Content</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Product - Does Not Fit - item not fitted e.g item   delivered does not fit the customer </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Customer - Change of Mind  </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Not As Expected</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                </table>
            </div>

            <p><br>
                <br>
                <strong>Please see table below to know the reasons you can return an item for various categories</strong><br>
                <strong><i class="red-text">x </i>  Not Required</strong><br/><strong><i class="green-text">✓ </i> Required</strong></p>
            <div class="table-responsive">
                <table class="table table-striped" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><br>
                            <strong>Category</strong></td>
                        <td><p><strong>Customer Changed Mind</strong></p></td>
                        <td><p><strong>Wrong Item</strong></p></td>
                        <td><p><strong>Damaged Item</strong></p></td>
                    </tr>
                    <tr>
                        <td><p>Fashion</p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Beauty &amp; Cosmetics</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                    </tr>
                    <tr>
                        <td><p>Perfumes</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                    </tr>
                    <tr>
                        <td><p>Underwear &amp; Swimwear</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                    </tr>
                    <tr>
                        <td><p>Jewelry</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                    </tr>
                    <tr>
                        <td><p>Mobile Phones</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Electronics</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Computing</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Vinyl, DVD, Software</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Books</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Consumables (Food)</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                    <tr>
                        <td><p>Large Bulky Items</p></td>
                        <td><p><i class="red-text bolder">x </i> </p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                        <td><p><i class="green-text bolder">✓ </i></p></td>
                    </tr>
                </table>
            </div>

            <p>&nbsp;</p>
            <p>Please note that processing and exchanges will take a maximum of 25 calendar days.</p>
        </div>
    </div>
@endsection