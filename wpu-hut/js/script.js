function tampilkanSemuaMenu() {
  $.getJSON('data/pizza.json', function(data) {
    let menu = data.menu;
    let content = '';

    $.each(menu, function(i, item) {
      content += `
        <div class="col-md-4">
          <div class="card mb-3">
            <img src="img/menu/${item.gambar}" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title">${item.nama}</h5>
              <p class="card-text">${item.deskripsi}</p>
              <h5 class="card-title">Rp. ${item.harga}</h5>
              <a href="#" class="btn btn-primary">Pesan Sekarang</a>
            </div>
          </div>
        </div>`;
    });

    $('#daftar-menu').html(content);
  });
}

tampilkanSemuaMenu();

$('.nav-link').on('click', function() {
  $('.nav-link').removeClass('active');
  $(this).addClass('active');

  let kategori = $(this).html();
  $('h1').html(kategori);

  if (kategori.toLowerCase() === 'all menu') {
    tampilkanSemuaMenu();
    return;
  }

  $.getJSON('data/pizza.json', function(data) {
    let menu = data.menu;
    let content = '';

    $.each(menu, function(i, item) {
      if (item.kategori.toLowerCase() === kategori.toLowerCase()) {
        content += `
          <div class="col-md-4">
            <div class="card mb-3">
              <img src="img/menu/${item.gambar}" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">${item.nama}</h5>
                <p class="card-text">${item.deskripsi}</p>
                <h5 class="card-title">Rp. ${item.harga}</h5>
                <a href="#" class="btn btn-primary">Pesan Sekarang</a>
              </div>
            </div>
          </div>`;
      }
    });

    $('#daftar-menu').html(content);
  });
});
