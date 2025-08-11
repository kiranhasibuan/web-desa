<x-error-layout>
  <!-- error-section -->
  <section class="error-section centred pt_150 pb_120">
    <div class="pattern-layer" style="background-image: url('{{ asset('assets/images/shape/shape-25.png') }}')"></div>
    <div class="auto-container">
      <div class="content-box">
        <h1>503</h1>
        <h3>SEDANG MAINTENANCE</h3>
        <p>
          Kami sedang mengusahakan peningkatan kualitas <br />untuk memberikan pengalaman pengguna yang
          lebih baik.
        </p>
        <a href="{{ url('/') }}" class="theme-btn btn-one">Harap Menunggu, Layanan akan kembali</a>
      </div>
    </div>
  </section>
  <!-- error-section end -->
</x-error-layout>
