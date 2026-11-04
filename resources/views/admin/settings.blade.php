<x-admin-layout title="Settings">
    <p class="admin-intro">Email alerts and contact details. Menus, footer, SEO and the privacy policy are under <a href="{{ route('admin.pages.index') }}">Pages &amp; content</a>; cohort dates and fees are under <a href="{{ route('admin.cohort.edit') }}">Mentorship cohort</a>.</p>
    <form class="admin-settings" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        <section class="admin-panel form">
            <header><h2>Email alerts</h2><p class="field-hint">Every enquiry, application and sign-up is saved here first, so nothing is lost if an email fails.</p></header>
            <x-field name="notification_email" label="Send new submissions to" type="email" optional :value="$settings['notification_email']" hint="Leave blank to turn alerts off. Requires mail settings on the server." />
            <label class="check switch"><input type="checkbox" name="send_receipts" value="1" @checked(old('send_receipts', $settings['send_receipts']))> <span>Send people a confirmation email when they submit a form</span></label>
        </section>
        <section class="admin-panel form">
            <header><h2>Book</h2></header>
            <label class="check switch"><input type="checkbox" name="book_waitlist_open" value="1" @checked(old('book_waitlist_open', $settings['book_waitlist_open']))> <span>Book waiting list is open</span></label>
        </section>
        <section class="admin-panel form">
            <header><h2>Contact and social</h2></header>
            <div class="form-row">
                <x-field name="contact_email" label="Public contact email" type="email" optional :value="$settings['contact_email']" hint="Shown on the contact page and footer." />
                <x-field name="linkedin_url" label="LinkedIn URL" type="url" optional :value="$settings['linkedin_url']" />
            </div>
            <x-field name="instagram_url" label="Instagram URL" type="url" optional :value="$settings['instagram_url']" />
        </section>
        <div><button class="btn" type="submit">Save settings <span class="btn-icon"><x-line-icon name="check" /></span></button></div>
    </form>
</x-admin-layout>
