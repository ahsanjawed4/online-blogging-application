<?php
  function pdf_generator($fname,$lname,$email,$password,$dob,$gender,$address){
    class PDF extends FPDF{
      public function header(){
        date_default_timezone_set("Asia/Karachi");
        $this->SetFont("Times","B",12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0,10,"Date: ".date("d-M-Y") ."   Time:" .date("h:i:s A"),0,1,"R");
        $this->SetFillColor(45, 176, 208);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont("Times","B",30);
        $this->Cell(0,20,"***Online Blogging Application***",0,1,"C",1);
        $this->Ln(10);
      }
      public function footer(){
        $this->SetFont("Times","",12);
        $this->AliasNbPages();
          $this->Text(170,290,"Page " .$this->PageNo()  ." of  {nb}");
        }
    }
    $pdf=new PDF;
    $pdf->addPage();
    $pdf->SetFont("Times","B",22);
    $pdf->MultiCell(0,5,"Acount Detail",0,"C",0);
    $pdf->ln(7);
    $pdf->Cell(39,5,"Full Name:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$fname ." " .$lname,0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(23,5,"Email:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$email,0,1,"J",0,"https://accounts.google.com/v3/signin/identifier?dsh=S553996839%3A1683395041461320&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&ifkv=Af_xneFiTZrBe5Ijlg-TmKcCFTmbI1syPl96QJET88taFMzC8I229IJLgQy8zwzwko9Wh9fD5Cjetg&rip=1&sacu=1&service=mail&flowName=GlifWebSignIn&flowEntry=ServiceLogin");
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(35,5,"Password:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$password,0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(49,5,"Date Of Birth:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$dob,0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(29,5,"Gender:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$gender,0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(31,5,"Address:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,$address,0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(20,5,"Role:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,"User",0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(55,5,"Account Status:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,"InActive",0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(65,5,"Account Approval:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->Cell(0,5,"Pending",0,1,"J",0);
    $pdf->ln(7);
    $pdf->SetFont("Times","B",22);
    $pdf->Cell(32,5,"Message:",0,0,"J",0);
    $pdf->SetFont("Times","",16);
    $pdf->MultiCell(0,7,"Wait for the response we are working on your request you will recieve an email at: " .$email." as soon as possible. Thank You for registration:-",0,"J",0);
    $pdf->output("D",$fname."_".$lname.".pdf");
  }
?>