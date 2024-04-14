const BsModal = 
{
  confirm({
    title = '',
    content = '',
    onOk = ()=> {},
    onCancel = ()=> {}


  }) 
  {
    const elemento = document.createElement('div');
    elemento.innerHTML = `<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">${title}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ${content}
        </div>
        <div class="modal-footer">
          <button type="button" id="cancel" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="button" id="ok" class="btn btn-primary">Si</button>
        </div>
      </div>
    </div>
  </div>`;
    document.body.appendChild(elemento);
    const myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'))
    myModal.show();
    document.getElementById('cancel').addEventListener('click', (e) =>{
      e.preventDefault();
      onCancel();
      myModal.hide();
    });
    document.body.appendChild(elemento);
    document.getElementById('ok').addEventListener('click', (e) =>{
      e.preventDefault();
      onOk();
      myModal.hide();
    });
  }
}