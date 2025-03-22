@extends('layouts.master')

@section('content')
<main id="about-main" class="about-us-page">
    <!-- About Us Section -->
    <section class="introduction">
        <h2>About Us</h2>
        <p>
            Welcome to <strong>Glided Canvas</strong>, a platform dedicated to connecting people with extraordinary art. 
            We are proud to offer unique art pieces and provide a space for up-and-coming artists to showcase their talent.
        </p>
        <p>
            Our mission is to make stunning, original art accessible to all while fostering a community that uplifts emerging artists, 
            helping them gain the recognition they deserve.
        </p>
    </section>

    <hr class="about-us-divider"> <!-- Divider between About Us and Our Mission -->

    <!-- Mission Statement Section -->
    <section class="mission">
        <h2>Our Mission</h2>
        <p>
            At Glided Canvas, we believe that every piece of art tells a story and that every artist deserves a chance to be seen. 
            We work tirelessly to bridge the gap between art lovers and creators, ensuring that your purchase supports and celebrates creativity.
        </p>
    </section>

    <hr class="about-us-divider"> <!-- Divider between Our Mission and Meet Our Team -->

    <!-- Team Section -->
    <section class="team">
        <h2>Meet Our Team</h2>
        <p>
            Behind Glided Canvas is a passionate team of art enthusiasts, curators, and innovators dedicated to making art accessible 
            and empowering the next generation of artists.
        </p>
    </section>
    @auth
    <div class="text-center my-5">
        <a href="{{ route('website.review.create') }}" class="rate-link-custom">Rate Your Experience</a>
    </div>
@endauth

<!-- Styling for the Rate Your Experience link -->
<style>
    .rate-link-custom {
        display: inline-block;
        font-family: 'Merriweather', serif;
        font-size: 1.4rem;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 50px;
        background-color: #d4af37;
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .rate-link-custom:hover {
        background-color: #b08a2e;
        transform: scale(1.05);
        text-decoration: none;
        color: white;
    }
</style>

</main>
@endsection

