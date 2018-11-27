using ConsoleRESTClient.Model;
using System;


namespace ConsoleRESTClient
{
    class Program
    {
        static void Main(string[] args)
        {
            DataMapper dt = new DataMapper();

            // GET single post
            //dt.GetSingleEntry(50).Wait();

            // GET list
            //dt.GetDataList().Wait();

            // POST single post
            Post newUser = new Post();
            newUser.Title = "Pling plong";
            newUser.Body = "This is a fantastic text.";
            newUser.UserId = 10;
            newUser.ID = 101;

            //dt.PostEntry(newUser).Wait();

            // PUT / MODIFY / UPDATE

            // DELETE post
            dt.DeleteEntry(7).Wait();

        }

        
    }
}
