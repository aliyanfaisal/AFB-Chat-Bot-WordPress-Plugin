<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://afbinc.epizy.com
 * @since      1.0.0
 *
 * @package    Chat_Bot_Ai
 * @subpackage Chat_Bot_Ai/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
$chatBotDB = getChatBotDB();
$enable = $chatBotDB->getValue("enable_chatbot");
$side = $chatBotDB->getValue("chatbot_side");
$starter_msg = $chatBotDB->getValue("starter_msg");
$botName = $chatBotDB->getValue("chatbot_name");
$companyName = $chatBotDB->getValue("company_name");
$adminEmail = $chatBotDB->getValue("admin_email");
$adminContactNumber = $chatBotDB->getValue("admin_phone_number");
$adminWhatsapp = $chatBotDB->getValue("admin_whatsapp");

$poweredByText = $chatBotDB->getValue("powered_by_text");
$poweredByText = $poweredByText['code'] == 200 ? $poweredByText['data']->meta_value : "";

$poweredByTextUrl = $chatBotDB->getValue("powered_by_text_link");
$poweredByTextUrl = $poweredByTextUrl['code'] == 200 ? $poweredByTextUrl['data']->meta_value : "";

$textOnHoverWidget = $chatBotDB->getValue("widget_hover_text");
$textOnHoverWidget = $textOnHoverWidget['code'] == 200 ? $textOnHoverWidget['data']->meta_value : "";

$chatBotLogo = $chatBotDB->getValue("chatbot_logo");
$chatBotLogo = $chatBotLogo['code'] == 200 ? $chatBotLogo['data']->meta_value :  ChatBotUrl . "/public/img/logo.png";;
$botName = $botName['code'] == 200 ? $botName['data']->meta_value : "Maven";

if ($enable['code'] == 200) {
    if ($enable['data']->meta_value == "off") {
        return false;
    }
}



// THEME VARIABLES HERE

$themeColor = $chatBotDB->getValue("chatbot_theme_color");
$themeColor = $themeColor['code'] == 200 ? $themeColor['data']->meta_value : "#17494d";

$fontColor = $chatBotDB->getValue("chatbot_theme_font_color");
$fontColor = $fontColor['code'] == 200 ? $fontColor['data']->meta_value : "#ffffff";



?>


<style>
    :root {
        --theme-color: <?php echo $themeColor; ?>;
        --font-color: <?php echo $fontColor; ?>;
    }
</style>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.cdnfonts.com/css/samsung-sharp-sans" rel="stylesheet">


<style>
    #body-chatbot a:hover {
        color: inherit !important;
        text-decoration: underline !important;
    }

    #body-chatbot *:not(i) {
        font-family: 'Samsung Sharp Sans', sans-serif !important;

    }

    .feedback_a {
        font-size: 16px !important;
        color: var(--font-color) !important;
        /* text-decoration: none; */
        float: right;
        margin: 0px 10px !important;
    }

    .notusefull_a {
        font-size: 14px !important;
        color: grey !important;
        cursor: pointer !important;
    }

    .flex-links {
        border-top: 1px solid #c6c5c579;
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        padding: 2px 5px;
    }

    .flex-links a {
        font-size: 12px !important;
    }

    .myPopover {
        /* background-color: rgb(23, 73, 77); */
        text-align: center;
    }

    .f-14 {
        font-size: 16px !important;
        margin-bottom: 3px !important;
    }


    .popover-header {
        color: var(--font-color);
        background-color: var(--theme-color);
    }

    .popover {
        border-radius: 15px !important;
        color: var(--font-color);
        background-color: var(--theme-color)
    }

    .popover * {
        font-family: 'Samsung Sharp Sans', sans-serif !important;
    }

    #chatLog {
        border-radius: 0px 0px 20px 20px;
    }

    .myPopover {
        cursor: pointer;
    }
</style>

<div id="body-chatbot">


    <!--button-->
    <div id="chat-circle" class="btn btn-raised" style="<?php echo $side['data']->meta_value == 'off' ? 'left' : 'right' ?>:20px !important">
        <div id="chat-overlay"></div>
        <!--<i class="material-icons">android</i>-->
        <img id="popover_1" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" class="chat-circle_robot" src="<?php echo $chatBotLogo; ?>">
    </div>

    <!--chat-bot-->
    <div class="chat-box" style="<?php echo $side['data']->meta_value == 'off' ? 'left' : 'right' ?>:20px !important">
        <div class="chat-box-body">
            <!--welcome message-->
            <div class="chat-box-welcome__header">
                <div class="chat-box__header-text">
                    <p3 class="chat-box-welcome__company-name"> Hi, I'm <b><?php echo $botName; ?> </b></p3>
                    <span class="chat-box-toggle"> <i class="fa-solid fa-xmark"></i> </span>
                </div>

                <div id="chat-box-welcome__ava">
                    <!--<i class="material-icons">android</i>-->
                    <img class="chat-box-welcome_robot" src="<?php echo $chatBotLogo; ?>">
                </div>
                <div class="chat-box-welcome__welcome-text">
                    <p><?php echo  $starter_msg['code'] == 200 ? $starter_msg['data']->meta_value : "Hi I’m Maven your customer delight bot. I’m powered by AI technology and here to help answer your questions in a delightful way. How can we help you today?" ?></p>

                    <div class="flex-links" style="">
                        <a href="#" class='feedback_a' onclick='showContactMsg()'> Contact Us? </a>
                        <a href="#" class='feedback_a' onclick='chatWithHuman()'> Chat with a Human? </a>
                        <a class="feedback_a" href='#' onclick='askFeedback()'> Leave Feedback </a>
                    </div>
                </div>
                <!--<div id="chat">

            </div>-->
            </div>




            <!--chat-bot after welcome was toggled-->
            <div id="chat-box__wraper">
                <div id="chat-box__wraperheader" class="chat-box-header" style="padding: 8px !important;">
                    <div class="d-flex align-items-center px-2">
                        <i class="fa-solid fa-arrow-left goBack"></i>
                        <img style="width: 50px;height:50px;" class="chat-box-welcome_robot mx-2" src="<?php echo $chatBotLogo; ?>">
                        <span class="font-weight-bold">Maven</span>
                    </div>
                    <span class="chat-box-toggle"> <i class="fa-solid fa-xmark"></i> </span>
                </div>



                <div class="chat-box-overlay">
                </div>


                <div class="chat-logs" id="confetti">


                    <!-- MESSAGES WILL BE INSERTED HERE  -->


                    <!-- <div class="text-center"><p>loader 1</p><div class="loader1"></div></div> -->
                    <div class="spin-container">
                        <div class="spiner">
                            <div aria-hidden="true"></div>
                            <div aria-hidden="true"></div>
                            <div aria-hidden="true"></div>
                        </div>
                    </div>



                </div>
                <!--chat-log-->
            </div>

        </div>
        <div class="chat-input-box" id="chatLog" style="background-color: rgb(255, 255, 255);">
            <div class="chat-input__form">
                <input type="text" class="chat-input__text" id="chat-input__text" data-type="normal" placeholder="Send a message..." />
                <button type="submit" class="chat-submit" id="chat-submit" style="visibility: hidden;">
                    <!-- <div style="width: 32px;height: 32px;background-image: url('<?php echo ChatBotUrl . "/public/img/send.png"; ?>');background-size: contain;"> -->

                    <!-- </div> -->
                </button>
            </div>
            <p6 class="chat-box__sign">Powered by <a class="link-light" href="<?php echo $poweredByTextUrl; ?>"> <?php echo $poweredByText; ?> </a></p6>
        </div>
    </div>
</div>
<!-- end live-chat -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://confettijs.org/confetti.min.js"></script>
<script>
    var exampleEl = document.getElementById('popover_1')



    var options = {
        "animation": true,
        delay: {
            "show": 200,
            "hide": 100
        },
        "html": true,
        "placement": "left",
        "trigger": "manual",
        "title": "<?php echo $textOnHoverWidget; ?>",
        "offset": [2, 8],
        "customClass": "myPopover"
    }
    var popover = new bootstrap.Popover(exampleEl, options)
    if ($(window).width() < 500) {


        popover.dispose()
    }

    $("#popover_1").click(function() {
        popover.hide()

    })


    // $(".fa-solid.fa-xmark").click(function(){
    //     console.log("shownnn")
    //     popover.show()
    //     // popover.update()
    // })

    setTimeout(function() {

        if ($(window).width() > 500) {
            // console.log("greater then")
            popover.show()

            $(".myPopover").click(function(e) {
                e.preventDefault()
                popover.hide()
                // console.log("yeah")
                $("#chat-circle").trigger("click")
            })
        }


    }, 10)
</script>


<script>
    // MAIN VARIABLES
    const botName = "<?php echo $botName; ?>";
    const currentUserName = "<?php echo ucwords(wp_get_current_user()->display_name); ?>"
    const adminContactNumber = "<?php echo $adminContactNumber['code'] == 200 ? $adminContactNumber['data']->meta_value : ''; ?>";
    const adminEmail = "<?php echo $adminEmail['code'] == 200 ? $adminEmail['data']->meta_value : ''; ?>";
    const adminWhatsapp = "<?php echo $adminWhatsapp['code'] == 200 ? $adminWhatsapp['data']->meta_value : ''; ?>";



    var greeted = false
        var askedQuestions = 0;
        var allMsgs = []
        var enteringUserData = false
        var UserPersonalData = []
        var CustomMessages = []
        var showedCustomMessages = 0;
        var askPersonalInfoAgain = true

        var stopMsgs = false
        $("#chat-input__text").attr("data-type", 'normal')
    function initiateOrResetVars() {
         greeted = false
         askedQuestions = 0;
         allMsgs = []
         enteringUserData = false
         UserPersonalData = []
         CustomMessages = []
         showedCustomMessages = 0;
         askPersonalInfoAgain = true

         stopMsgs = false

         $("#chat-input__text").attr("data-type", 'normal')
         $("#chat-input__text").removeAttr("data-entered")
         $("#chat-input__text").attr("type","text")
    }

    // initiateOrResetVars()



    var lastBotMsg = ""

    //AJAX
    const restRouteUrl = "<?php echo get_rest_url(); ?>"




    var getBotMsg = (msg) => {

        lastBotMsg = msg
        return `<div  class="chat-msg bot" style="display: flex">
                    <span>
                        <!--<i class="material-icons">android</i>-->
                        <img class="chat-box-overlay_robot" src="<?php echo $chatBotLogo ?>">
                    </span>
                    <div class="cm-msg-text">
                        ${msg}
                    </div>
                </div>`;
    }

    var getUserMsg = (msg) => {
        return `<div  class="chat-msg user" style="display: flex;justify-content:flex-end">
                    <div class="cm-msg-text">
                        ${msg}
                    </div>
                    <span>
                        <!--<i class="material-icons">android</i>-->
                        <img class="chat-box-overlay_robot" src="<?php echo get_avatar_url(get_current_user_id()) ?? $chatBotLogo; ?>">
                    </span>
                </div>`;
    }
</script>
<script src="<?php echo ChatBotUrl . '/public/js/chat-bot-widget.js'; ?>"></script>





<script>
    $("#chat-circle").draggable({
        drag: function(event, ui) {
            //        
            // console.log(event.target)
            console.log("ui", $(window).width())

            $(".chat-box").css({
                "left": ($(window).width() > (ui.position.left + 450) ? ui.position.left : $(window).width() - 450) + "px",
                "bottom": ($(".chat-box").height() < (ui.position.top) ? 50 : ui.position.top) + "px"
            })

        }
    });


    $(".chat-box").draggable({
        start: function(event, ui) {
            $(this).css("height", $(this).height())
        },
        drag: function(event, ui) {
            //        
            console.log(event.target)
            console.log("ui", ui)

            // $("#chat-circle").css({
            //     "left":ui.position.left+"px",
            //     "bottom":(ui.position.top-70) +"px"
            // })

        },
        stop: function(event, ui) {
            // $(this).css("height", "auto")
        }
    });
</script>