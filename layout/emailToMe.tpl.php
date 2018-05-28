<?php
return <<<HTML
<html><body>
<table cellpadding="0" width="580" cellspacing="0" border="0" bgcolor="#F4F7FA" align="center" style="margin:0 auto;table-layout:fixed"  bgcolor="blue">      
    <tbody>  
        <tr> 
            <td colspan="4">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td colspan="2" height="30"></td>
                        </tr>
                        <tr>
                            <td valign="top" align="center">
                                <a href="$this->site" style="display:inline-block;text-align:center" target="_blank">
                                    <img src="https://i.imgur.com/O1RM2ys.png" height="32" border="0" alt="$this->site">
                                </a>  
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" height="30"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr> 

        <tr style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif;color:#4e5c6e;"> 
            <td colspan="4">
                <table bgcolor="#F4F7FA" width="100%" cellpadding="0" cellspacing="0" border="1" style="color:#48545d;">
                    <tr align="center">
                        <th colspan="1" height="30">nome</th>
                        <th colspan="1" height="30">cognome</th> 
                        <th colspan="1" height="30">telefono</th>
                        <th colspan="1" height="30">email</th>
                    </tr>
                    <tr align="center">
                        <td colspan="1" height="40">$this->nameSender</td>
                        <td colspan="1" height="40">$this->surnameSender</td>
                        <td colspan="1" height="40">$this->telSender</td>
                        <td colspan="1" height="40">$this->emailSender</td>
                    </tr>
                </table> 
            </td>
        </tr> 

        <tr> 
            <td colspan="4">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:4px">
                    <tbody>
                        <tr>
                            <td height="40"></td>
                        </tr>
                        <tr style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif;color:#4e5c6e;font-size:14px;line-height:20px;margin-top:20px">
                            <td colspan="2" valign="top" align="center" style="padding-left:90px;padding-right:90px">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
                                    <tbody>
                                        <tr>
                                            <td align="center" valign="bottom" colspan="2" cellpadding="3">
                                                <img alt="email" width="80" src="https://i.imgur.com/UiZ2ObP.png">
                                            </td>         
                                        </tr>
                                        <tr><td height="30"></td></tr>
                                        <tr>
                                            <td align="center">
                                                <span style="color:#48545d;font-size:22px;line-height:24px">$this->titleTpl</span>               
                                            </td>
                                        </tr>
                                        <tr><td height="24"></td></tr>
                                        <tr>
                                            <td height="1" bgcolor="#DAE1E9"></td>
                                        </tr>
                                        <tr><td height="24"></td></tr>
                                        <tr>
                                            <td align="center">
                                                <span style="color:#48545d;font-size:14px;line-height:24px">
                                                $this->infoTpl   
                                                </span>
                                            </td>
                                        </tr>
                                        <tr><td height="20"></td></tr>
                                     
                                        <tr><td height="20"></td></tr>
                                        <tr>
                                            <td align="center"><hr><img src="" width="54" height="2" border="0"></td>
                                        </tr>
                                        <tr><td height="20"></td></tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="60"></td>
                        </tr>
                    </tbody>
                </table>     

                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td valign="top" align="center" colspan="2" height="50" style="padding-top:20px">
                                <span style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI','Roboto','Oxygen','Ubuntu','Cantarell','Fira Sans','Droid Sans','Helvetica Neue',sans-serif;color:#9eb0c9;font-size:10px">©
                                    <a href="$this->site" style="color:#9eb0c9!important;text-decoration:none" target="_blank">$this->site</a> 2018
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td height="50">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>  
        </tr>
    </tbody>       
</table> 
</body></html>
HTML;






