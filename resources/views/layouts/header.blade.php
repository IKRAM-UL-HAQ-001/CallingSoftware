<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Calling Exchange Software
    </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
    <style>
        .dataTables_filter {
            float: right;
        }
        .dataTables_filter label {
            font-weight: bold;
        }
        .dataTables_filter input {
            width: 200px;
            border-radius: 5px;
            padding: 5px;
            margin-left: 5px;
        }
    
        .dataTables_paginate {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        #userTable_paginate{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 50%;
            border: 1px solid #ddd;
            color: #007bff;
            cursor: pointer;
        }
        .dataTables_paginate .paginate_button:hover {
            background-color: #f0f0f0;
        }
        .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            color: white !important;
            border: 1px solid #007bff;
            border-radius: 50%;
            padding: 3px 10px;
        }
    </style>
    <style>
        table tbody{
            color: white !important;
        }
        .bg-gradient-to-white {
            background: linear-gradient(to bottom, #f0f0f0, white);
        }

        .test1 {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9));
            /* Replace with your desired gradient */
            color: white;
            opacity: 1;
        }

        .form-control {
            color: black;
            border: 1px solid #ced4da;
            /* Default Bootstrap border color */
            border-radius: 0.25rem;
            /* Bootstrap border radius */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .d-sm-inline,
        .breadcrumb-item {
            font-weight: bold;
            color: black;
        }

        .form-label {
            color: black;
        }

        .text-capitalize {
            font-weight: bold;
            color: white;
        }

        .nav-link-text {
            font-weight: bold;
        }
        .nav-link.active {
        background-color: #344767 !important; /* Dark background color */
        color: #ffffff !important; /* White text color */
        font-weight: bold;
        border-radius: 5px;
    }

        .form-control:focus {
            border-color: #80bdff;
            /* Border color on focus */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Shadow on focus */
        }

        input::placeholder {
            padding-left: 10px;
            color: #aaa;
        }

        .modal-header {
            background-color: #343a40;
            color: white;
        }

        .td-large {
            width: 45%;
        }

        .td-small {
            width: 10%;
            text-align: center;
        }

        .modal-header {
            background-color: #343a40;
            color: white;
        }

        .table thead tr th {
            color: black !important;
            font-size: 14px !important;
            font-weight: bold !important;
            text-transform: uppercase !important;
        }

        /* .table tbody tr:nth-child(odd) {
            background-color: #4a6696;
            color: white;
        }

        .table tbody tr:nth-child(odd) td {
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: white !important;
            color: black !important;
        }

        .table tbody tr:nth-child(even) td {
            background-color: white !important;
            color: #4a6696; !important;
        }


        .table tbody tr:nth-child(odd):hover {
            background-color: #4a6696; !important;
            color: white !important;
        }

        .table tbody tr:nth-child(even):hover {
            background-color: #4a6696 !important;
            color: black !important;
        } */

    </style>
</head>
