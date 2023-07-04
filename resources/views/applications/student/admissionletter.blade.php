<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<style type="text/css">


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
<body style="">

<div style="background-color:#fff;position:relative;width:750px;height:auto;margin:0 auto;border: 1px solid #000000;overflow: hidden;min-height:1000px;padding-bottom:5px;">
 <img src="{{$application->BachelorInstituteName->InstituteBG}} " style="width:750px;height:1000px;margin:0 auto;"/>
 <div style="display:block;width:650px;position:absolute;margin:20px 10px 5px 50px;height: auto;min-height:1000px;     top: 0px;left:0;z-index:1;">  
  
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;border-bottom: 0px solid #cc0000;">
   <tr>
    <td style="vertical-align:middle;width: 50%;text-align:left;">
     
     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.5;font-size:13px;font-style:italic;"><br> <br>  <br>   </p></td>
    
   </tr>
  </table>

  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
   
   <tr>
    <td style="vertical-align:middle;width: 30%;text-align:left;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">REF: TOPUP{{$application->user->id}}-{{$application->id}}</p> </td>
 
     
     
    <td style="vertical-align:middle;width: 30%;text-align:right;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">{{$application->status}} on {{$application->updated_at}}</p>
    </td> <p align="center"><button onclick="window.print()" >Print your admission</button></p>   
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;">
   <tr>
    <td style="vertical-align:middle;width: 70%;text-align:left;font-style:italic;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">To</p>
     <p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Applicant Name:</b> {{$application->user->firstname}} {{$application->user->middlename}} {{$application->user->surname}} <b>s/o, d/o :</b> {{$application->user->guardian_firstname}} {{$application->user->guardian_middlename}} {{$application->user->guardian_surname}}</p>
     <p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Address:</b> {{$application->user->address}}</p>
     <p style="padding: 0px;margin:0;color:#000;line-height:1.2;font-size:11px;"><b>Email Address:</b> {{$application->user->email}} <b>Mobile Number:</b> {{$application->user->mobilenumber}}</p> </br>
    </td>
    <td style="vertical-align:middle;width: 30%;text-align:right;">
     <img style="height:90px" src="https://admission.mewar.ac.ae{{$application->user->profile}}" height="90px">
    </td>    
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:center;">
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;">
     Subject: Provisional Admission Offer letter for prospective admission at {{$application->BachelorInstituteName}} subjected to confirmation of the conditions prescribed by the Institute management</p> </br>
    </td>        
   </tr>
  </table>
  Samer Khan, [7/4/2023 5:13 PM]
<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">     
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">Dear {{$application->user->firstname}} {{$application->user->middlename}} {{$application->user->surname}} ,</p>
     
     
     <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:justify;">
We at the {{$application->BachelorInstituteName}}  would like to firstly congratulate you on showing interest at wanting to study at our Institute. {{$application->BachelorInstituteName}} would like to appreciate you on selecting us for your further studies and indeed assure you that you have taken the right deicsion.
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
        <b>Course Name: </b>{{$application->course->degree_in_view}}  
       </td>
       </table>
       <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;line-height:1.2;font-size:10px;font-weight:normal;">
      
       <td style="vertical-align:top;width: 50%;text-align:left;">
         <b>One Time Form Fee: </b> USD 100
       </td>
       <td style="vertical-align:top;width: 50%;text-align:left;"> <b>Program Charges: </b> {{$application->BachelorInstituteName->Course->Tuition Fees}} 
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
      <li>55% in your Higher National Diploma of your country.</li>
      <li>Copy of your Transcript and Degree as proof of graduation</li>
     </ol>
    </td>
   </tr>
  </table>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
  
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;"> 
     <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:justify;">
We wish you the best of luck and congratulate you once again for making the right choice in selecting  {{$application->BachelorInstituteName}} for studying your HND to Bachelors Toup. You will receive a separate email with respect to payment process.</br><br/>
</p>   
     <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:5px;text-align:left;"></p>
     
  <p style="padding: 0px;margin:0;font-weight: normal;color:#000;line-height:1.2;font-size:11px;text-align:center;"><b>
If you have further queries feel free to reach out to us via email at admission@mewar.ac.ae or contact us through live chat support by visiting the following link https://m.me/mewardubai or through direct whatsapp at +971522524669</b><br/>
  <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;">
   <tr>
    <td style="vertical-align:middle;width: 100%;text-align:left;">

Samer Khan, [7/4/2023 5:13 PM]
<table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:5px;line-height:1.2;font-size:10px;font-weight:normal;">
      <tr>
       <td style="vertical-align:top;width: 30%;text-align:left;">        
       </td>
       <td style="vertical-align:top;width: 70%;text-align:right;">        
        <table border="0" style="width:100%;vertical-align:middle;border-collapse:collapse;margin-top:0px;line-height:1.2;font-size:10px;font-weight:normal;font-style:italic;">
         <tr>
          <td style="vertical-align:top;width: 40%;text-align:right;">        
       <img src=" {{$application->BachelorInstituteName->Seal.png}} " height="80px;" />
          </td>
          <td style="vertical-align:top;width: 60%;text-align:right;">
           
           
           <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;">For and on behalf of  {{$application->BachelorInstituteName}} </p>
       <img src=" {{$application->BachelorInstituteName->InstituteSignature}} " height="35px;" />
          
          <p style="padding: 0px;margin:0;font-weight: bold;color:#000;line-height:1.2;font-size:11px;margin-bottom:0px;"> {{$application->BachelorInstituteName->representative Name}} <br/>Admission Officer<br/> {{$application->BachelorInstituteName->instituteAdminEmail}} </p>
          
           
          
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