using System;
using System.Threading.Tasks;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Collections.Generic;
using ConsoleRESTClient.Model;

namespace ConsoleRESTClient
{
    public class DataMapper
    {
        private string baseUrl = "https://jsonplaceholder.typicode.com/";
        private string route;
        private HttpResponseMessage response;
        private HttpClient client = new HttpClient();

        public DataMapper()
        {
            this.client.BaseAddress = new Uri(this.baseUrl);
            this.client.DefaultRequestHeaders.Accept.Clear();
            this.client.DefaultRequestHeaders.Accept.Add(new MediaTypeWithQualityHeaderValue("application/json"));
        }

        public async Task GetSingleEntry(int id)
        {
            this.route = "posts/" + id;
            this.response = await this.client.GetAsync(this.route);

            if (this.response.IsSuccessStatusCode)
            {
                Post user = await this.response.Content.ReadAsAsync<Post>();
                Console.WriteLine(user.UserId + " - " + user.ID + " - " + user.Title + " - " + user.Body);
            }
        }

        public async Task GetDataList()
        {
            this.route = "posts";
            this.response = await this.client.GetAsync(this.route);

            if (this.response.IsSuccessStatusCode)
            {
                List<Post> myList = await this.response.Content.ReadAsAsync<List<Post>>();
                for (int i = 0; i < 5/*myList.Count*/; i++)
                {
                    Console.WriteLine(myList[i].UserId + " - " + myList[i].ID + " - " + myList[i].Title + " - " + myList[i].Body);
                }
            }

        }

        public async Task PostEntry(Post newUser)
        {
            this.response = await this.client.PostAsJsonAsync("posts", newUser);

            if (this.response.IsSuccessStatusCode)
            {
                Uri postUrl = this.response.Headers.Location;
                Console.WriteLine(postUrl);
                Console.WriteLine(this.response);
            }

        }

        public async Task DeleteEntry(int id)
        {
            this.response = await this.client.DeleteAsync("posts/" + id);

            if (this.response.IsSuccessStatusCode)
            {
                Console.WriteLine(this.response);
            }
        }



    }
}
