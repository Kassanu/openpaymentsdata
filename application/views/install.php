<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        margin: 40px;
        font: 16px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
        word-wrap: break-word;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
    }

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>

<div id="container">
    <h1>Install</h1>

    <div id="body">
        <p>
        1. Set Codeigniter database configuration.
        <br>
        Please open the "database.php" file located in "/application/config/". Everything can remain default but fill in your connection info for 'hostname', 'username' and 'password'.
        </p>
        <p>
        2. Create schema on MySQL server.
        <br>
        This script requires the schema defined in the "database.php" file to already be created. On your MySQL server create a schema named 'openpaymentsdata' it should be utf8_unicode_ci
        </p>
        <p>
        3. Set your Openpaymentsdata app token.
        <br>
        Open the "config.php" file located in "/application/config/".  There should be an option for 'openpaymentsdata_token' at the end of the file.  Set this to your App Token for your Open Payments Data application. You can generate one by logging into your profile on https://openpaymentsdata-origin.cms.gov.
        </p>
        <p>
        4. Create and seed database.
        <br>
        Click the link below to create and seed the database.  Only run this once on install, you can delete this controller after installation is completed.
        <br>
        This will take a long time, 12 hours when I did it. It is probably not the most effecient. If there was more time I would look into maybe a multithreading situation where I can parse multiple chunks of data in parallel.
        <br>
        By default this will pull all data but I left some testing code to only pull a certain amount of data just to test whether things were working without having to spend hours downloading all the data each time. In the "Installer_model" you can look at lines 439-445 in the "seedDatabase()" method to see instructions on how to change this
        </p>
        <p>
            <a href="/install/run" class="btn btn-primary">Install</a>
        </p>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '' ?></p>
</div>

</body>
</html>
