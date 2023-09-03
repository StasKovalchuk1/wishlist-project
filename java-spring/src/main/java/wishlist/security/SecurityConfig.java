package wishlist.security;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import wishlist.User;
import wishlist.data.UserRepository;

import javax.servlet.http.HttpSession;

@Configuration
public class SecurityConfig extends WebSecurityConfigurerAdapter {

    @Bean
    public PasswordEncoder passwordEncoder() { return new BCryptPasswordEncoder(); }

    @Override
    protected void configure(HttpSecurity http) throws Exception {
        http
                .authorizeRequests()
                .antMatchers("/mywishlist", "/searchPage/reservation").access("hasRole('USER')")
                .antMatchers("/", "/**").access("permitAll()")

                .and()
                .formLogin()
                .loginPage("/login")

                .and()
                .logout()
                .logoutSuccessUrl("/");
    }

    @Bean
    public UserDetailsService userDetailsService(UserRepository userRepository, HttpSession session) {
        return username -> {
            User user = userRepository.findByUsername(username);
            if (user != null) {
                session.setAttribute("username", user.getUsername());
                return user;
            }
            throw new UsernameNotFoundException("User " + username + " not found.");
        };
    }
}
