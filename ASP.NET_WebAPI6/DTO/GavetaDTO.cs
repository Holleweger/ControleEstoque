using System.ComponentModel;

namespace ControleEstoque.DTO
{
    public class GavetaDTO
    {
        public int Id { get; set; }

        public string Nome { get; set; }

        public string Codigo { get; set; }

        public virtual GondolaDTO? Gondola { get; set; }
    }
}
