using Newtonsoft.Json;

namespace ControleEstoque.DTO
{
    public class Produto_GavetaDTO
    {
        public virtual int Id { get; set; }

        public virtual long Quantidade { get; set; }

        public virtual GavetaDTO Gaveta { get; set; }

        public virtual ProdutoDTO Produto { get; set; }
    }
}
