using Newtonsoft.Json;

namespace ControleEstoque.DTO
{
    public class FiltroProduto_GavetaDTO
    {
        public int Id { get; set; }

        public string Produto { get; set; }

        public string Gaveta { get; set; }
    }
}
