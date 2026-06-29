<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }
        body {
            margin: 3cm 2cm 2cm;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            color: rgb(22, 3, 3);
            text-align: center;
            line-height: 30px;
            border-radius: 8px;  
            align-items: center;
            box-shadow: 0 4px 8px rgba(46, 45, 45, 0.1);
            justify-content: center;
            padding: 0 10px;
            display: flex;
            flex-direction: column;
        }
       
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 35px;
        }
        .header-rpt-titulo {
            width: 40%;
            height: 5%;
             text-align: center;
             font-size: x-large;
             font-family: 'Times New Roman', Times, serif;
             margin-top: 2%;
             margin-left: 30%;
        }
        .header-rpt-fecha {
            position: fixed;
            top: 0.5cm;
            left: 0cm;
            right: 1cm;
            height: 2cm;
            text-align: right;
            font-size:medium;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.2;

      
        }
        .card-data-cliente {
            width: 100%; 
            height: 15%;
            position: relative;
            margin-top: 0%;
            background-color: #ebe7e7;
            align-items: center;
            border: 1px solid#494848 ;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0,0, 0.1);
            display: flex;
            flex-direction: column;            
        }        
        .logo-rpt {
            position: absolute;
            align-items: flex-start;
            background-image: "../public/Back/images/LogoWebFinalNegro.png";
            background-size: cover; /* Cubre todo el div */
            background-position: contain; /* Centra la imagen */
            background-repeat: no-repeat; /* No repite la imagen */
        }        
        .div-table-solicitud  {
            position: fixed;
            top: 2cm;
            left: 0.5cm;
            right: 0.5cm;
            height: 80%;
        }
    </style>
</head>
