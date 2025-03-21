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
        <a href="{{ route('website.review.create') }}" class="btn btn-primary mt-3">Rate Your Experience</a>
    @else
        <p class="mt-3">
            <a href="{{ route('login') }}">Log in</a> to rate your experience on The Gilded Canvas.
        </p>
    @endauth
</main>
@endsection

