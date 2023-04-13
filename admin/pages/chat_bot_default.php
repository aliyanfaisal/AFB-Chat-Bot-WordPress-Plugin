<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php

wp_enqueue_media();
// INITTIATE DATABASE
$chatBotDB = getChatBotDB();


// SAVE GENERAL SETTINGS TO DATABASE
if (isset($_POST['submit'])) {

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit;

    try {
        foreach ($_POST as $field => $value) {
            $chatBotDB->insertOrUpdate($field, $value);
        }


?>
        <script>
            swal("Good job!", "Settings Updated Successfully", "success");
        </script>

    <?php
    } catch (Exception $e) {
    ?>
        <script>
            swal("Opps!", "<?php $e->getMessage(); ?>", "error");
        </script>

    <?php
    }
}




// SAVE FAQs TO DATABASE
if (isset($_POST['submit_custom_messages'])) {

    try {
        $msg = $_POST['chatbot_message'];
        $tags = $_POST['message_tags'];

        $newAdd = [
            "message" => $msg,
            "tags" => $tags
        ];

        // get old messages from db 
        $oldCustomMsgs = $chatBotDB->getValue("chatbot_custom_messages");
        $oldCustomMsgs = $oldCustomMsgs['code'] == 200 ? $oldCustomMsgs['data']->meta_value : "";

        $un_serialize_custom_msgs = unserialize($oldCustomMsgs);
        if ($un_serialize_custom_msgs) {
            array_push($un_serialize_custom_msgs, $newAdd);
        } else {
            $un_serialize_custom_msgs[] = $newAdd;
        }


        $chatBotDB->insertOrUpdate("chatbot_custom_messages", serialize($un_serialize_custom_msgs));



    ?>
        <script>
            swal("Good job!", "FAQ added Successfully", "success");
        </script>

    <?php
    } catch (Exception $e) {
    ?>
        <script>
            swal("Opps!", "<?php $e->getMessage(); ?>", "error");
        </script>

    <?php
    }
}




if (isset($_POST['delete_cust_msg'])) {

    try {
        $id = $_POST['cust_msg_id'];

        $oldCustomMsgs = $chatBotDB->getValue("chatbot_custom_messages");
        $oldCustomMsgs = $oldCustomMsgs['code'] == 200 ? $oldCustomMsgs['data']->meta_value : "";

        $un_serialize_custom_msgs = unserialize($oldCustomMsgs);

        unset($un_serialize_custom_msgs[$id]);

        $chatBotDB->insertOrUpdate("chatbot_custom_messages", serialize($un_serialize_custom_msgs));

    ?>
        <script>
            swal("Success!", "Custom Message Deleted", "success");
        </script>

    <?php
    } catch (Exception $e) {
    ?>
        <script>
            swal("Opps!", "<?php $e->getMessage(); ?>", "error");
        </script>

<?php
    }
}



$allData = $chatBotDB->getAll()['data'];

// $oldCustomMsgs = $chatBotDB->getValue("chatbot_custom_messages");
$oldCustomMsgs = $allData['chatbot_custom_messages'];
$un_serialize_custom_msgs = unserialize($oldCustomMsgs);




?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />



<div class="" style="padding:0px; min-height:100vh">
    <div class="h2 mt-3">Settings Page</div>
    <div class="">
        <div class="col-12">
            <div class="card col-12">
                <!-- Default card contents -->


                <div class="row px-2">


                    <div class="col-md-2 col-12">
                        <ul class=" card nav nav-pills  card-header-tabs nav-fill flex-column px-2" role="tablist">
                            <li class="nav-item mb-4">
                                <a class="nav-link active" data-bs-toggle="tab" href="#General" role="tab" aria-current="true" href="#"> General</a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="nav-link" data-bs-toggle="tab" href="#customization" role="tab" href="#">Customization</a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="nav-link" data-bs-toggle="tab" href="#FAQ" role="tab" href="#">FAQs</a>
                            </li>
                            <li class="nav-item mb-4">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Pro Version</a>
                            </li>
                        </ul>

                    </div>

                    <div class="tab-content card col-md-10 col-12">

                        <!-- // GENERATL SETTINGS FORM  -->
                        <form class="card-body px-3 tab-pane fade show active" method="post" id="General" role="tabpanel">
							
                        <h4 class="mb-4">General Settings:</h4>

                            <div class="material-switch d-flex justify-content-between align-items-center ">
                                <label class="form-label" for=""> Enable Chat Bot:</label>

                                <input type="text" hidden name="enable_chatbot" value="off">
                                <input class="switch enable_chatbot" value="off" name="enable_chatbot" id="enable_chatbot" name="someSwitchOption001" type="checkbox" autocomplete="off" />

                                <label for="enable_chatbot" class="label-primary label"></label>
                            </div>
                            <hr class="p-0 mx-1">




                            <div class="d-flex flex-wrap">
                                <div class="col-md-6 col-12 ">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Chat Bot Name:</label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-robot"></i> </span>
                                        <input required value="<?php echo isset($allData['chatbot_name']) ? $allData['chatbot_name'] : ''; ?>" type="text" class="form-control" placeholder="Bot Name" name="chatbot_name" aria-label="Username" aria-describedby="addon-wrapping">
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 ">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Text on Widget Hover:</label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-comment"></i></span>
                                        <input value="<?php echo isset($allData['widget_hover_text']) ? $allData['widget_hover_text'] : ''; ?>" type="text" class="form-control" placeholder="A text that Pops-up on hovering Widget" name="widget_hover_text" aria-label="Username" aria-describedby="addon-wrapping">
                                    </div>
                                </div>

                            </div>


                            <div class="col">
                                <!-- Starter Text  -->
                                <label for="" class="form-label">Starter Message:</label>
                                <div class="input-group flex-nowrap mb-3">
                                    <span class="input-group-text" id="addon-wrapping"><i class="fa-regular fa-message"></i> </span>
                                    <textarea required rows="4" type="text" class="form-control" placeholder="Bot Name" name="starter_msg" aria-label="Username" aria-describedby="addon-wrapping"><?php echo isset($allData['starter_msg']) ? $allData['starter_msg'] : ""; ?></textarea>
                                </div>

                            </div>
                            <hr>


                            <h4 class="mb-2">Contact Settings:</h4>
                            <div class="d-flex flex-wrap mt-4">
                                <div class="col-md-6 col-12 ">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Your Company Title:</label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-building"></i> </span>
                                        <input required value="<?php echo isset($allData['company_name']) ? $allData['company_name'] : get_bloginfo("name"); ?>" type="text" class="form-control" placeholder="Your Company Name" name="company_name" aria-label="" aria-describedby="addon-wrapping">
                                    </div>

                                </div>

                                <div class="col-md-6 col-12">

                                    <!-- Name input -->
                                    <label for="" class="form-label">Admin Email: <span>(to send emails)</span></label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-at"></i> </span>
                                        <input required value="<?php echo isset($allData['admin_email']) ? $allData['admin_email'] : get_bloginfo("admin_email"); ?>" type="text" class="form-control" placeholder="Admin Email" name="admin_email" aria-label="" aria-describedby="addon-wrapping">
                                    </div>


                                </div>

                            </div>


                            <div class="d-flex flex-wrap">
                                <div class="col-md-6 col-12 ">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Admin Phone Number: <span>(to send calls)</span></label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-phone"></i> </span>
                                        <input required value="<?php echo isset($allData['admin_phone_number']) ? $allData['admin_phone_number'] : ''; ?>" type="text" class="form-control" placeholder="Phone Number To Contact" name="admin_phone_number" aria-label="" aria-describedby="addon-wrapping">
                                    </div>


                                </div>

                                <div class="col-md-6 col-12">

                                    <!-- Name input -->
                                    <label for="" class="form-label">Admin WhatsApp: <span>(with country code)</span></label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa-brands fa-whatsapp"></i> </span>
                                        <input required value="<?php echo isset($allData['admin_whatsapp']) ? $allData['admin_whatsapp'] : ''; ?>" type="text" class="form-control" placeholder="WhatssApp Number" name="admin_whatsapp" aria-label="" aria-describedby="addon-wrapping">
                                    </div>

                                </div>

                            </div>

                            <!-- Submit button -->
                            <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Save</button>
                        </form>
                        <!-- // GENERATL SETTINGS FORM  -->





                        <!-- 

                    *info
                            CUSTOMIZATION
                    *
                    *
                     -->
                     

                        <form class="tab-pane card-body fade px-3" action="" method="POST" id="customization" role="tabpanel">
<h4 class="mb-4">General Settings:</h4>

                            <div class="material-switch d-flex justify-content-between  align-items-center ">
                                <label class="form-label mr-5" for=""> Side to Show:</label>
                                <span>Left</span>
                                <input type="text" hidden name="chatbot_side" value="off">
                                <input class="switch" value="off" id="chatbot_side" name="chatbot_side" type="checkbox" autocomplete="off" />

                                <label for="chatbot_side" class="label-primary label"></label>
                                <span>Right</span>
                            </div>

                            <hr>



                            <div class="d-flex flex-wrap">
                                <div class="col-md-6 col-12 px-0">
                                    <label for="chatbot_logo" class="form-label">Select ChatBot Logo:  <span class="text-muted f12 f12" style="font-size:14px">( Use 1:1 size image )</span></label>
                                    <div class="d-flex">
                                        <input class="form-control col-5" type="file" id="chatbot_logo_btn">
                                        <input class="form-control" type="text" hidden id="chatbot_logo" name="chatbot_logo" value="<?php echo isset($allData['chatbot_logo']) ? $allData['chatbot_logo'] :  ChatBotUrl . "/public/img/logo.png";  ?>">

                                    </div>
                                </div>
                                <div class="col-md-4 col-8 px-0">
                                    <div class="col-md-6 col-12">
                                        <img src="<?php echo isset($allData['chatbot_logo']) ? $allData['chatbot_logo'] :  ChatBotUrl . "/public/img/logo.png"; ?>" id="chatbot_logo_img" style="width: 100px !important;" alt="">

                                    </div>
                                </div>
                            </div>



                            <hr>
                            <h4 class="mb-2">Theme Settings:</h4>
                            <div class="d-flex flex-wrap mt-4">
                                <div class="col-md-6 col-12 px-0">
                                    <!-- Name input -->
                                    <label for="chatbot_theme_color" class="form-label">Theme Color</label><br>
                                    <input required type="color" style="height: 40px;" class=" form-control-color" id="chatbot_theme_color" value="<?php echo isset($allData['chatbot_theme_color']) ? $allData['chatbot_theme_color'] : "#17494d"; ?>" title="Choose Theme color" name="chatbot_theme_color">
                                </div>

                                <div class="col-md-6 col-12">
                                    <!-- Name input -->
                                    <label for="chatbot_theme_font_color" class="form-label">Font Color</label><br>
                                    <input required type="color" style="height: 40px;" class=" form-control-color" id="chatbot_theme_font_color" value="<?php echo isset($allData['chatbot_theme_font_color']) ? $allData['chatbot_theme_font_color'] : "#ffffff"; ?>" title="Choose Font color" name="chatbot_theme_font_color">
                                </div>
                            </div>

                            <hr>
                            <h4>Additional Settings:</h4>
                            <div class="d-flex flex-wrap">
                                <div class="col-md-6 col-12 px-0">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Powered By Text:</label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa-solid fa-copyright"></i></span>
                                        <input value="<?php echo isset($allData['powered_by_text']) ? $allData['powered_by_text'] : 'Move Up Marketing Group'; ?>" type="text" required class="form-control" placeholder="Move Up Marketing Group" name="powered_by_text" aria-label="" aria-describedby="addon-wrapping">

                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <!-- Name input -->
                                    <label for="" class="form-label">Powered By Text Link: <span class="text-muted f12 f12">optional</span></label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa fa-link"></i> </span>
                                        <input value="<?php echo isset($allData['powered_by_text_link']) ? $allData['powered_by_text_link'] : 'https://MoveUpMarketingGroup.com'; ?>" type="text" class="form-control" placeholder="Link to the text" name="powered_by_text_link" aria-label="" aria-describedby="addon-wrapping">

                                    </div>
                                </div>
                            </div>

                   

                    <!-- Submit button -->
                    <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Save Settings</button>
                    </form>




                    <!-- 

                    *
                            FAQ
                    *
                    *
                     -->

                    <!-- // FAQ FORM  -->
                    <div class="tab-pane fade px-3" id="FAQ" role="tabpanel">
                        <form action="" method="POST">
                            <h4>Add Bot Custom Messages</h4>
                          

                            <div class="d-flex flex-wrap mt-4">
                                <div class="col-md-7 col-12 ">

                                    <!-- Name input -->
                                    <label for="" class="form-label">Add A Bot Message:</label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa fa-envelope"></i> </span>
                                        <input style="height: 60px;" type="text" required class="form-control" placeholder="Enter a Custom Message" name="chatbot_message" aria-label="" aria-describedby="addon-wrapping">

                                    </div>


                                </div>

                                <div class="col-md-5 col-12 ">


                                    <label for="" class="form-label">Add Words Related the Bot Question: <span class="text-muted f12 f12" style="font-size: 12px;"> Your word will trigger the Bot message. ( each word comman separated )</span></label>
                                    <div class="input-group flex-nowrap mb-3">

                                        <span class="input-group-text" id="addon-wrapping"> <i class="fa fa-tag"></i> </span>
                                        <input type="text" required class="form-control" placeholder="contact, seo, marketing" name="message_tags" aria-label="" aria-describedby="addon-wrapping">

                                    </div>

                                </div>


                            </div>



                            <!-- Submit button -->
                            <button type="submit" name="submit_custom_messages" class="btn btn-primary btn-block mb-4">Add Message</button>
                        </form>



                        <hr>
                        <h2>Custom Messages</h2>


                        <table class="table table-hover table-responsive-sm table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Tags</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($un_serialize_custom_msgs as $key => $msg) {
                                ?>
                                    <tr>
                                        <th scope="row"> <?php echo $key + 1; ?> </th>
                                        <td> <?php echo $msg['message']; ?></td>
                                        <td style="padding: 0px 15px;"> <b><?php echo $msg['tags']; ?></b></td>

                                        <td class="text-center">
                                            <form action="" method="post" class="d-flex align-items-start">
                                                <input type="text" hidden value="<?php echo $key; ?>" name="cust_msg_id">
                                                <button class="btn btn-sm btn-danger mb-2 mr-2" type="submit" name="delete_cust_msg">Delete</button>
                                                <a href="#" class="btn btn-sm btn-primary" name="edit_cust_msg">Edit</a href="#">
                                            </form>


                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>





<script>
    jQuery(function($) {




        $(".switch").change(function() {
            var vall = $(this).val()

            if (vall == "on") {
                $(this).val("off")
            } else {
                $(this).val("on")
            }


            // console.log($(this), $(this).val())
        })

        /**@abstract
         * 
         * 
         * ON the TRUE SWITCHES HERE
         */


        <?php
        foreach ($allData as $key => $value) {

            if ($value == "on") {
        ?>
                var e = $(".switch[name='<?php echo $key ?>']")
                // console.log("forech ", e, e.val())
                e.click();
                // e.change();

        <?php
            }
        }

        ?>






        /**@abstract
         * 
         * 
         * 
         * MEDIA SELECTOR
         */

        var mediaUploader;

        $('#chatbot_logo_btn').click(function(e) {
            e.preventDefault();
            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on('select', function() {
                attachment = mediaUploader.state().get('selection').first().toJSON();
                console.log("attachment", attachment)
                $('#chatbot_logo').val(attachment.url);
                $("#chatbot_logo_img").attr("src", attachment.url)
            });
            // Open the uploader dialog
            mediaUploader.open();
        });


    })
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
