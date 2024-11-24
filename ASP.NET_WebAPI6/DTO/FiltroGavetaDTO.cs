using Newtonsoft.Json;

namespace ControleEstoque.DTO
{
    public class FiltroGavetaDTO
    {
        public int Id { get; set; }

        public string Nome { get; set; }

        public string Codigo { get; set; }

        public GondolaDTO GondolaDTO { get; set; }
    }
}
