using System;
using System.Collections.Generic;
using System.Text;

namespace ConsoleRESTClient.Model
{
    public class Post
    {
        public long ID { get; set; }
        public long UserId { get; set; }
        public String Title { get; set; }
        public String Body { get; set; }
    }
}
