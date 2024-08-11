using Newtonsoft.Json;

namespace ControleEstoque.DTO
{
    public class GondolaDTO
    {
        public int Id { get; set; }

        [JsonProperty(NullValueHandling = NullValueHandling.Ignore)]
        public string Nome { get; set; }

        [JsonProperty(NullValueHandling = NullValueHandling.Ignore)]
        public string Codigo { get; set; }
    }
}
