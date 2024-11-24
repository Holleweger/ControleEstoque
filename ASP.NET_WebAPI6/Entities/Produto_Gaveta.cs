
namespace ControleEstoque.Entities
{
    public partial class Produto_Gaveta
    {
        public int Id { get; set; }

        public long Quantidade { get; set; }

        public int GavetaId { get; set; }

        public Gaveta Gaveta { get; set; }

        public int ProdutoId { get; set; }

        public Produto Produto { get; set; }
    }
}
