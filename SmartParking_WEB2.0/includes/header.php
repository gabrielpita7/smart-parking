<?php require_once("../models/session.php"); ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartParking UFBA</title>

    <!-- Core CSS - Include with every page -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrapValidator.min.css"/>
     <link rel="stylesheet" href="../css/style.css"/>

    <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>

    <!-- SB Admin CSS - Include with every page -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $('#attributeForm').bootstrapValidator();
        });
    </script>

    <script>
$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'O Login é obrigatório'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'A Senha é obrigatória'
                    }
                }
            }
        }
    });
});
</script>
    
</head>

<body>