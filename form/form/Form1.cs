using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Net;
using System.Text;
using System.Windows.Forms;
using Newtonsoft.Json;

namespace form
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        private string ReadConfig()
        {
            FileStream fs = new FileStream(AppDomain.CurrentDomain.BaseDirectory+"\\config.txt", FileMode.Open);

            StreamReader sr = new StreamReader(fs);

            var readLine = sr.ReadLine();
            sr.Close();
            fs.Close();
            if (readLine != null) return readLine.Trim().Split(',')[0];
            else
            {
                return "";
            }
           
        }
        private string GetCode()
        {
            int number;
            char code;
            string checkCode = String.Empty;
            Random random = new Random();
            for (int i = 0; i < 6; i++)
            {
                number = random.Next();
                if (number%2 == 0)
                    code = (char) ('0' + (char) (number%10));
                else
                    code = (char) ('0' + (char) (number%10));
                checkCode += code.ToString();
            }
            return checkCode.ToLower();
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            label1.Text = GetCode();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            webBrowser1.Url = new Uri(ReadConfig());
            label1.Text = GetCode();
        }

        private void pd_PrintPage(object sender, System.Drawing.Printing.PrintPageEventArgs e)
        {
            e.Graphics.DrawImage(pictureBox2.Image, 0, 0, pictureBox1.Image.Width, pictureBox1.Image.Height);
        }

        class Pic
        {
            public string uid { get; set; }
            public string picurl { get; set; }
        }
        IList<Pic> pics=new List<Pic>(); 
        private void timer2_Tick(object sender, EventArgs e)
        {
          
            if (pics.Count > 1)
            {
               
                    for (int i = 0; i < pics.Count; i++)
                    {
                     var  pic = pics[i];
                    if (!string.IsNullOrEmpty(pic.picurl) && pic.picurl != "21312312312312")
                    {
                        try
                        {
                            pics.Remove(pic);

                            timer1.Enabled = false;
                            timer2.Enabled = false;
                            label1.Text = "打印中...";

                            var _url = "http://print.wx.dlwebs.com/uploads/" + pic.picurl + ".jpg";

                            Random seed = new Random();
                            WebRequest webreq = WebRequest.Create(_url);
                            WebResponse webres = webreq.GetResponse();
                            Stream stream = webres.GetResponseStream();
                            Image image;
                            image = Image.FromStream(stream);
                            stream.Close();
                            pictureBox2.Image = image;

                            printDocument1.PrintPage += new System.Drawing.Printing.PrintPageEventHandler(this.pd_PrintPage);
                            printDocument1.Print();

                            var url = "http://print.wx.dlwebs.com/query.php?uid=" + pic.uid.Trim();
                            var wc = new WebClient();
                            wc.DownloadString(url).Trim();

                            pictureBox2.Image = null;
                            timer1.Enabled = true;
                            timer2.Enabled = true;
                            label1.Text = GetCode();

                        }
                        catch (Exception)
                        {


                        }
                       
                    }

                    }
                
            

                  
          
            }
            else
            {
                
                try
                {
                    var url = "http://print.wx.dlwebs.com/query.php";
                    var wc = new WebClient();
                    var picurl = wc.DownloadString(url).Trim();
                    pics = JsonConvert.DeserializeObject<IList<Pic>>(picurl);
                }
                catch (Exception)
                {
                    
                     
                }
                 

            }
      
            
           


        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }
    }
}