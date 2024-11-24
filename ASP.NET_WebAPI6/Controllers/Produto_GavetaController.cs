using ControleEstoque.DTO;
using ControleEstoque.Entities;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using System.Net;

namespace ControleEstoque.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    public class Produto_GavetaController : ControllerBase
    {
        private readonly DBContext DBContext;

        public Produto_GavetaController(DBContext DBContext)
        {
            this.DBContext = DBContext;
        }

        [HttpGet("GetProdutoGaveta")]
        public async Task<ActionResult<List<Produto_GavetaDTO>>> Get()
        {
            var List = await DBContext.Produto_Gaveta.Select(
                s => new Produto_GavetaDTO
                {
                    Id = s.Id,
                    Quantidade = s.Quantidade,
                    Produto = new ProdutoDTO()
                    {
                        Id = s.Produto.Id,
                        Nome = s.Produto.Nome,
                        Codigo = s.Produto.Codigo,
                    },
                    Gaveta = new GavetaDTO()
                    {
                        Id = s.Gaveta.Id,
                        Nome = s.Gaveta.Nome,
                        Codigo = s.Gaveta.Codigo,
                        Gondola = new GondolaDTO()
                        {
                            Id = s.Gaveta.Gondola.Id,
                            Nome = s.Gaveta.Gondola.Nome,
                            Codigo = s.Gaveta.Gondola.Codigo,
                        }
                    }
                }
            ).ToListAsync();

            if (List.Count < 0)
            {
                return NotFound();
            }
            else
            {
                return List;
            }
        }

        [HttpGet("GetProdutoGavetaById/{id}")]
        public async Task<ActionResult<Produto_GavetaDTO>> GetProdutoGavetaById(int Id)
        {
            Produto_GavetaDTO produtoGaveta = await DBContext.Produto_Gaveta.Select(
                    s => new Produto_GavetaDTO
                    {
                        Id = s.Id,
                        Quantidade = s.Quantidade,
                        Produto = new ProdutoDTO()
                        {
                            Id = s.Produto.Id,
                            Nome = s.Produto.Nome,
                            Codigo = s.Produto.Codigo,
                        },
                        Gaveta = new GavetaDTO()
                        {
                            Id = s.Gaveta.Id,
                            Nome = s.Gaveta.Nome,
                            Codigo = s.Gaveta.Codigo,
                            Gondola = new GondolaDTO()
                            {
                                Id = s.Gaveta.Gondola.Id,
                                Nome = s.Gaveta.Gondola.Nome,
                                Codigo = s.Gaveta.Gondola.Codigo,
                            }
                        }
                    })
                .FirstOrDefaultAsync(s => s.Id == Id);

            if (produtoGaveta == null)
            {
                return NotFound();
            }
            else
            {
                return produtoGaveta;
            }
        }

        [HttpPost("FiltrarProdutoGaveta")]
        public async Task<ActionResult<List<Produto_GavetaDTO>>> FiltrarProdutoGaveta(FiltroProduto_GavetaDTO produtoGaveta)
        {
            var List = await DBContext.Produto_Gaveta.Select(
                s => new Produto_GavetaDTO
                {
                    Id = s.Id,
                    Quantidade = s.Quantidade,
                    Produto = new ProdutoDTO()
                    {
                        Id = s.Produto.Id,
                        Nome = s.Produto.Nome,
                        Codigo = s.Produto.Codigo,
                    },
                    Gaveta = new GavetaDTO()
                    {
                        Id = s.Gaveta.Id,
                        Nome = s.Gaveta.Nome,
                        Codigo = s.Gaveta.Codigo,
                        Gondola = new GondolaDTO()
                        {
                            Id = s.Gaveta.Gondola.Id,
                            Nome = s.Gaveta.Gondola.Nome,
                            Codigo = s.Gaveta.Gondola.Codigo,
                        }
                    }
                }
            ).ToListAsync();

            if (produtoGaveta.Id > 0)
            {
                List = List.Where(a => a.Id == produtoGaveta.Id).ToList();
            }

            if (produtoGaveta.Produto != null && produtoGaveta.Produto != "")
            {
                List = List.Where(a => a.Produto.Nome.ToUpper().Contains(produtoGaveta.Produto.ToUpper())).ToList();
            }

            if (produtoGaveta.Gaveta != null && produtoGaveta.Gaveta != "")
            {
                List = List.Where(a => a.Gaveta.Nome.ToUpper().Contains(produtoGaveta.Gaveta.ToUpper())).ToList();
            }

            return List;
        }

        [HttpPost("InsertProdutoGaveta")]
        public async Task<HttpStatusCode> InsertProdutoGaveta(Produto_GavetaDTO produtoGaveta)
        {
            try
            {
                var entity = new Produto_Gaveta()
                {
                    Quantidade = produtoGaveta.Quantidade,
                    GavetaId = produtoGaveta.Gaveta.Id,
                    ProdutoId = produtoGaveta.Produto.Id,
                    //Gaveta = new Gaveta() { Id = produtoGaveta.Gaveta.Id },
                    //Produto = new Produto() { Id = produtoGaveta.Produto.Id },
                };

                DBContext.Produto_Gaveta.Add(entity);
                var teste = await DBContext.SaveChangesAsync();
            }
            catch (Exception ex)
            {
                var teste = ex;
            }
            

            return HttpStatusCode.Created;
        }

        [HttpPut("UpdateProdutoGaveta")]
        public async Task<HttpStatusCode> UpdateProdutoGaveta(Produto_GavetaDTO produtoGaveta)
        {
            var entity = await DBContext.Produto_Gaveta.FirstOrDefaultAsync(s => s.Id == produtoGaveta.Id);

            entity.Id = produtoGaveta.Id;
            entity.Quantidade = produtoGaveta.Quantidade;
            entity.GavetaId = produtoGaveta.Gaveta.Id;
            entity.ProdutoId = produtoGaveta.Produto.Id;

            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }

        [HttpDelete("DeleteProdutoGaveta/{Id}")]
        public async Task<HttpStatusCode> DeleteProdutoGaveta(int Id)
        {
            var entity = new Produto_Gaveta()
            {
                Id = Id
            };
            DBContext.Produto_Gaveta.Attach(entity);
            DBContext.Produto_Gaveta.Remove(entity);
            await DBContext.SaveChangesAsync();
            return HttpStatusCode.OK;
        }
    }
}
