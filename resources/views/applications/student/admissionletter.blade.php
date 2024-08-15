<html>

<head>
  <div>
      <div class="watermark">AUTHENTIC ADMISSION ISSUED FOR {{ $application->student->name }} WITH APPROVAL ON {{ $application->updated_at }}</div>

     <div class="wave"></div>
     <div class="wave"></div>
     <div class="wave"></div>
  </div>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<style type="text/css">

body {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, 
        #e91e63 0%,     /* Violet */
        #9c27b0 10%,    /* Indigo */
        #2196f3 20%,    /* Blue */
        #4caf50 40%,    /* Green */
        #ffc107 60%,    /* Yellow */
        #ff5722 80%,    /* Orange */
        #f44336 100%    /* Red */
    );
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 1s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 1s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}
     /* Watermark styles */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            white-space: nowrap;
            pointer-events: none;
            z-index: 999;
            opacity: 0.5;
            animation: scrollWatermark 20s linear infinite;
        }

        @keyframes scrollWatermark {
            0% {
                transform: translate(-50%, -50%) translateX(100%);
            }
            100% {
                transform: translate(-50%, -50%) translateX(-100%);
            }
        }
body {
 font-size:11px;
 font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif, "Geeza Pro", "Nadeem", "Al Bayan", "DecoType Naskh", "DejaVu Serif", "STFangsong", "STHeiti", "STKaiti", "STSong", "AB AlBayan", "AB Geeza", "AB Kufi", "DecoType Naskh", "Aldhabi", "Andalus", "Sakkal Majalla", "Simplified Arabic", "Traditional Arabic", "Arabic Typesetting", "Urdu Typesetting", "Droid Naskh", "Droid Kufi", "Roboto", "Tahoma", "Times New Roman", "Arial", serif , "adobe arabic"
 ;
}
@page { margin: 0px; }
body { margin: 0px; }
@media print {
    html, body {
        height: 99%;    
    }
}
</style>
</head>
<br>
<br>
<br>
<br>
<br>
<body style="">

<div style="background-color:#fff;position:relative;width:750px;height:auto;margin:0 auto;border: 1px solid #000000;overflow: hidden;min-height:1000px;padding-bottom:5px;">
 <img src="{{ $application->institute->letterhead }}" style="width:750px;height:1000px;margin:0 auto;"/>
 <div style="display:block;width:650px;position:absolute;margin:20px 10px 5px 50px;height: auto;min-height:1000px;     top: 0px;left:0;z-index:1;">  
  
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;border-bottom: 0px solid #cc0000;">
   <tr>
    <td style="vertical-align:middle;width: 50%;text-align:left;">
     
     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.5;font-size:13px;font-style:italic;"><br> <br>  <br>   </p></td>
    
   </tr>
  </table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
   
   <tr>
    <td style="vertical-align:middle;width: 30%;text-align:left;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">REF: NBTE-HND/2023/OFFERLETTER/{{ $application->institute->id }}/{{ $application->student->id }}/{{ $application->id }} </p> </td>
 
     
     
    <td style="vertical-align:middle;width: 30%;text-align:right;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">{{ $application->status }} on {{ $application->updated_at }}</p>
    </td> <p align="center">
    <button onclick="history.back()">Go Back</button>

    <button onclick="window.print()" >Print your admission</button></p>   
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
   <tr>
    <td style="vertical-align:middle;width: 70%;text-align:left;font-style:italic;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">To</p>
     <p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Applicant Name:</b> {{ $application->student->name }}</p>
     <p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Email Address:</b> {{$application->student->email}} <b>Mobile Number:</b> {{$application->student->phone}}</p> </br>
    </td>
    <td style="vertical-align:middle;width: 30%;text-align:right;">
     <img style="height:90px" src="{{ $application->student->avatar }}" height="90px">
    </td>    
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:center;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">
     Subject: Provisional Admission Offer letter for prospective admission at {{ $application->institute->title }} subjected to confirmation of the conditions prescribed by the Institute management</p> </br>
    </td>        
   </tr>
  </table>
<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">Dear {{ $application->student->name }} ,</p>
     
     
     <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:justify;">
We at the {{ $application->institute->title }}  would like to firstly congratulate you on showing interest at wanting to study at our Institute. {{ $application->institute->title }} would like to appreciate you on selecting us for your further studies and indeed assure you that you have taken the right deicsion.
</p> </br>

    </td>        
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">Details of the program you have applied for:-</p>
     <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;line-height:1.2;font-size:10px;font-weight:normal;">
      
       <td style="vertical-align:top;text-align:left;">
        <b>Course Name: </b>{{ $application->course->title }}
       </td>
       </table>
       <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;line-height:1.2;font-size:10px;font-weight:normal;">
      
       
       <td style="vertical-align:top;width: 50%;text-align:left;"> <b>Institute Form Fee: </b> NGN {{ $fees->pivot->fees ?? 0 }}
       </td>
       
      </tr>
      
       

 
       </td>
 
      
      
     </table>    
    </td>
    
   </tr>
   
  </table></br>
  
 

  
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;margin-top: 0px;">Conditional requirements for admission confirmation:</p>
     <ol style="font-size:10px;margin:0;padding:0;margin-left: 20px;line-height: 1.5;">
      <li>55% in your National Diploma of your country.</li>
      <li>Copy of your Transcript and Degree as proof of graduation</li>
     </ol>
    </td>
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
  
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;"> 
     <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:justify;">
We wish you the best of luck and congratulate you once again for making the right choice in selecting  {{ $application->institute->title }} for studying your Higher National Diploma. You can go ahead and initiate your school fees payment from under the payments tab as soon as your student account is updated with the {{ $application->institute->title }} .</br><br/>
</p>   
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:5px;text-align:left;"></p>
     
  <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:center;"><b>
If you have further queries feel free to reach out to us via email at {{ $application->institute->officeremail }} or contact us through direct whatsapp or phone call at {{ $application->institute->phone }}</b><br/>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">
<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;line-height:1.2;font-size:10px;font-weight:normal;">
      <tr>
       <td style="vertical-align:top;width: 30%;text-align:left;">        
       </td>
       <td style="vertical-align:top;width: 70%;text-align:right;">        
        <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;line-height:1.2;font-size:10px;font-weight:normal;font-style:italic;">
         
         <tr>
          <td style="vertical-align:top;width: 40%;text-align:right;">

            @if ($application->institute->seal)
              <img src="{{ $application->institute->seal }}" height="80px;" />
            @else
              <img src="" height="80px;" />                
            @endif
          </td>
          <td style="vertical-align:top;width: 60%;text-align:right;">
           
           
           <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">For and on behalf of  {{ $application->institute->title }} </p>
            @if ($application->institute->signature)
                <img src="{{ $application->institute->signature }}" height="45px;" />
            @else
                <img src="" height="35px;" />                
            @endif 
          
          
          <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;"> {{ $application->institute->officername }} <br/>Admission Officer<br/> {{ $application->institute->officeremail }} </p>
          
           
          
         </td>
         </tr>
        </table>       
       </td>
      </tr>
     </table>     
    </td>        
   </tr>
  </table>
 <p style="page-break-before: always"> 
</body>

</html>
